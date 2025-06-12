<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Throwable; // Importar a classe Throwable para o catch

class ImportarAssociadosJob implements ShouldQueue
{
    use Queueable;

    /**
     * O número de vezes que o job pode ser tentado.
     * @var int
     */
    public $tries = 3;

    /**
     * O número de segundos que o job pode rodar antes de sofrer timeout.
     * @var int
     */
    public $timeout = 3600; // 1 hora, ajuste conforme necessário

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        Log::info('🏁 Início da execução do ImportarAssociadosJob');

        // Pega o ID máximo da sua tabela de destino (PostgreSQL)
        $max_associado = DB::connection('pgsql')->table('associado')->max('nr_associado') ?? 0;
        Log::info("Último nr_associado importado: {$max_associado}");

        $associadosProcessados = 0;
        $associadosIgnorados = 0;

        // Use chunkById para processar em lotes e evitar problemas de memória
        DB::connection('sqlsrv')
            ->table('Cli_For as c')
            // Fazendo LEFT JOIN para buscar o email na mesma consulta (Otimização N+1)
            ->leftJoin('Cli_For_Contatos as cont', 'c.Ordem', '=', 'cont.Ordem_Cli_For') 
            ->select('c.Ordem', 'c.Codigo', 'c.Nome', 'c.CPF_Sem_Literais', 'c.Endereco', 'c.RG_IE', 'c.Numero', 'c.Bairro', 'c.Complemento', 'c.CEP', 'cont.Email')
            ->where('c.Codigo', '<', 50000)
            ->where('c.Codigo', '>', $max_associado)
            // Adicional: Garantir que pegamos apenas um email se houver vários
            // E que a ordem seja consistente. chunkById precisa de um orderBy.
            ->groupBy('c.Ordem', 'c.Codigo', 'c.Nome', 'c.CPF_Sem_Literais', 'c.Endereco', 'c.RG_IE', 'c.Numero', 'c.Bairro', 'c.Complemento', 'c.CEP', 'cont.Email')
            ->chunkById(200, function ($novosAssociados) use (&$associadosProcessados, &$associadosIgnorados) {
            
                Log::info("Processando um lote de " . $novosAssociados->count() . " associados.");

                foreach ($novosAssociados as $associado) {
                    
                    // A verificação de existência do nr_associado se torna redundante
                    // devido à cláusula where > $max_associado, mas mantê-la é uma segurança extra.
                    // Para performance, pode ser removida se confiar na lógica.

                    DB::connection('pgsql')->beginTransaction();
                    try {
                        // Verifica se o CPF já existe
                        $pessoaExistente = DB::connection('pgsql')
                            ->table('pessoas')
                            ->where('cpf', $associado->CPF_Sem_Literais)
                            ->first();

                        if ($pessoaExistente) {
                            $pessoaId = $pessoaExistente->id;
                        } else {
                            $pessoaId = DB::connection('pgsql')->table('pessoas')->insertGetId([
                                'nome_completo' => $associado->Nome,
                                'cpf'           => $associado->CPF_Sem_Literais,
                                'email'         => $associado->Email, // Email já vem da consulta principal
                                'idt'           => $associado->RG_IE,
                                'status'        => 1,
                            ]);
                        }

                        // Inserir endereço
                        DB::connection('pgsql')->table('endereco_pessoas')->insert([
                            'id_pessoa'   => $pessoaId,
                            'logradouro'  => $associado->Endereco,
                            'numero'      => $associado->Numero,
                            'bairro'      => $associado->Bairro,
                            'complemento' => $associado->Complemento,
                            'cep'         => $associado->CEP,
                            'dt_inicio'   => now(),
                        ]);

                        // Inserir na tabela associado
                        $associadoId = DB::connection('pgsql')->table('associado')->insertGetId([
                            'id_pessoa'    => $pessoaId,
                            'nr_associado' => $associado->Codigo,
                        ]);

                        // Inserir status do associado
                        DB::connection('pgsql')->table('historico_associado')->insert([
                            'id_associado' => $associadoId,
                            'dt_inicio'    => now(),
                        ]);

                        DB::connection('pgsql')->commit();
                        $associadosProcessados++;

                    } catch (Throwable $e) { // Usar Throwable pega Exceptions e Errors
                        DB::connection('pgsql')->rollBack();
                        Log::error('Erro ao importar associado: ' . $e->getMessage(), [
                            'codigo_associado' => $associado->Codigo,
                            'trace' => $e->getTraceAsString() // Muito útil para depurar
                        ]);
                        $associadosIgnorados++;
                    }
                }
            }, 'Codigo'); // Informa ao chunkById para usar a coluna Codigo

        Log::info("✅ Execução do ImportarAssociadosJob finalizada. Processados: {$associadosProcessados}, Ignorados/Falhas: {$associadosIgnorados}");
    }
}