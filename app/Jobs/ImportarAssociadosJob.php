<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ImportarAssociadosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         $max_associado = DB::table('associado')->max('nr_associado')  ?? 0;
        // Consulta no banco SQL Server
        $novosAssociados = DB::connection('sqlsrv')
                ->table('Cli_For as c')
                ->select('Ordem', 'Codigo', 'Nome', 'CPF_Sem_Literais','Endereco','RG_IE', 'Numero', 'Bairro', 'Complemento', 'CEP')
                ->where('c.Codigo', '<', 50000)
                ->where('c.Codigo', '>', $max_associado)
                ->get();

         Log::info('ImportarAssociadosJob - Total de associados encontrados: ' . $novosAssociados->count());

        foreach ($novosAssociados as $associado) {


                $endereco = DB::connection('sqlsrv')
                ->table('Cli_For_Contatos')
                ->select('Email')
                ->where('Ordem_Cli_For', $associado->Ordem)
                ->orderBy('Ordem') // ou outro critério de prioridade
                ->first();

            DB::connection('pgsql')->beginTransaction();
            try {
                // Inserir na tabela pessoas
                $pessoaId = DB::connection('pgsql')->table('pessoas')->insertGetId([
                    'nome_completo' => $associado->Nome,
                    'cpf' => $associado->CPF_Sem_Literais,
                    'email' => $endereco->Email ?? null,
                    'idt' => $associado->RG_IE ?? null,
                    'status' => 1,
                    
                ]);

                 // Inserir endereço (você pode ajustar os campos conforme a estrutura real do cli_for)
                if ($endereco) {
                    DB::connection('pgsql')->table('endereco_pessoas')->insert([
                        'id_pessoa' => $pessoaId,
                        'logradouro' => $associado->Endereco,
                        'numero' => $associado->Numero ?? null,
                        'bairro' => $associado->Bairro ?? null,
                        'complemento' => $associado->Complemento ?? null,
                        'cep' => $associado->CEP ?? null,
                        'dt_inicio' => today(),
                    ]);
                }


                // Inserir na tabela associado
                $associadoId = DB::connection('pgsql')->table('associado')->insertGetId([
                    'id_pessoa' => $pessoaId,
                    'nr_associado' => $associado->Codigo,
                ]);

                // Inserir status do associado
                DB::connection('pgsql')->table('historico_associado')->insert([
                    'id_associado' => $associadoId,
                    'dt_inicio' => today(),
                ]);

                DB::connection('pgsql')->commit();
            } catch (\Exception $e) {
                DB::connection('pgsql')->rollBack();
                Log::error('Erro ao importar associado: ' . $e->getMessage(), ['id' => $associado->Ordem]);

            }

            Log::info('ImportarAssociadosJob finalizado com sucesso.');

        }

         Log::info('ImportarAssociadosJob com erros na execução.');
    }
}
