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

        $pgsql = DB::connection('pgsql');
        $sqlsrv = DB::connection('sqlsrv');

        $max_associado = $pgsql->table('associado')->max('nr_associado') ?? 0;
        Log::info("Último nr_associado importado: {$max_associado}");

        $associadosProcessados = 0;
        $associadosIgnorados = 0;

        $sqlsrv->table('Cli_For as c')
            ->leftJoin('Cli_For_Contatos as cont', 'c.Ordem', '=', 'cont.Ordem_Cli_For')
            ->selectRaw('
                c.Ordem, c.Codigo, c.Nome, c.CPF_Sem_Literais, c.Endereco, 
                c.RG_IE, c.Numero, c.Bairro, c.Complemento, c.CEP, 
                MAX(cont.Email) as email
            ')
            ->where('c.Codigo', '<', 50000)
            ->where('c.Codigo', '>', $max_associado)
            ->groupBy(
                'c.Ordem', 'c.Codigo', 'c.Nome', 'c.CPF_Sem_Literais', 'c.Endereco',
                'c.RG_IE', 'c.Numero', 'c.Bairro', 'c.Complemento', 'c.CEP'
            )
            ->chunkById(200, function ($novosAssociados) use (&$associadosProcessados, &$associadosIgnorados, $pgsql) {

                Log::info("🔄 Processando lote com {$novosAssociados->count()} associados.");

                $pgsql->beginTransaction();
                try {
                    foreach ($novosAssociados as $associado) {
                        Log::debug("➡️ Associado: Codigo {$associado->Codigo}, Email: " . ($associado->email ?? 'N/A'));

                        // Evita duplicidade na tabela 'associado'
                        $existeAssociado = $pgsql->table('associado')
                            ->where('nr_associado', $associado->Codigo)
                            ->exists();

                        if ($existeAssociado) {
                            Log::warning("⚠️ Associado já existe (nr_associado {$associado->Codigo}), ignorado.");
                            $associadosIgnorados++;
                            continue;
                        }

                        $pessoaExistente = $pgsql->table('pessoas')
                            ->where('cpf', $associado->CPF_Sem_Literais)
                            ->first();

                        if ($pessoaExistente) {
                            $pgsql->table('pessoas')
                                ->where('id', $pessoaExistente->id)
                                ->update([
                                    'email'  => $associado->email,
                                    'status' => 1,
                                ]);
                            $pessoaId = $pessoaExistente->id;
                        } else {
                            $pessoaId = $pgsql->table('pessoas')->insertGetId([
                                'nome_completo' => $associado->Nome,
                                'cpf'           => $associado->CPF_Sem_Literais,
                                'email'         => $associado->email,
                                'idt'           => $associado->RG_IE,
                                'status'        => 1,
                                'dt_cadastro'   => now(),
                            ]);
                        }

                        // Inserir endereço
                        $pgsql->table('endereco_pessoas')->insert([
                            'id_pessoa'   => $pessoaId,
                            'logradouro'  => $associado->Endereco,
                            'numero'      => $associado->Numero,
                            'bairro'      => $associado->Bairro,
                            'complemento' => $associado->Complemento,
                            'cep'         => $associado->CEP,
                            'dt_inicio'   => now(),
                        ]);

                        // Inserir associado
                        $associadoId = $pgsql->table('associado')->insertGetId([
                            'id_pessoa'    => $pessoaId,
                            'nr_associado' => $associado->Codigo,
                        ]);

                        // Histórico do associado
                        $pgsql->table('historico_associado')->insert([
                            'id_associado' => $associadoId,
                            'dt_inicio'    => now(),
                        ]);

                        $associadosProcessados++;
                    }

                    $pgsql->commit();
                } catch (Throwable $e) {
                    $pgsql->rollBack();
                    Log::error('❌ Erro ao importar lote de associados. Lote revertido.', [
                        'erro' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                    $associadosIgnorados += $novosAssociados->count();
                }

            }, 'Codigo'); // importante: qualificar coluna para chunkById

        Log::info("✅ Fim do ImportarAssociadosJob. Processados: {$associadosProcessados}, Ignorados: {$associadosIgnorados}");
    }
}