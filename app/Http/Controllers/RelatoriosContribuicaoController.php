<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection; // Certifique-se de importar Collection

class RelatoriosContribuicaoController extends Controller
{

    public function index(Request $request)
    {

         // 🔗 Conexões
        $pgsql = DB::connection('pgsql');
        $sqlsrv = DB::connection('sqlsrv');

        // 🔍 Filtros
        $setorFiltro = $request->input('setor');
        $reuniaoFiltro = $request->input('reuniao');
        $membroFiltro = $request->input('membro');
        $anoFiltro = $request->input('ano') ?? date('Y');

        // 🔢 Paginação dos resultados FINAIS AGRUPADOS (por ano)
        $perPage = 5; // Ajuste este valor conforme necessário
        $currentPage = $request->get('page', 1);

        // 1. 🔥 Buscar TODOS os associados relevantes (PostgreSQL)
        $queryAssociados = $pgsql->table('associado AS a')
            ->leftJoin('membro AS m', 'a.id', 'm.id_associado')
            ->leftJoin('tipo_funcao AS tf', 'm.id_funcao', 'tf.id')
            ->leftJoin('cronograma AS c', 'm.id_cronograma', 'c.id')
            ->leftJoin('grupo AS g', 'c.id_grupo', 'g.id')
            ->leftJoin('pessoas AS p', 'a.id_pessoa', 'p.id')
            ->leftJoin('setor AS s', 'g.id_setor', 's.id')
            ->leftJoin('tipo_dia AS td', 'c.dia_semana', 'td.id')
            ->select(
                'a.nr_associado',
                'p.id as pid',
                'p.nome_completo',
                'tf.nome AS membro_funcao',
                'g.nome AS nome_grupo',
                's.sigla AS siglas',
                'c.id AS cronograma_id',
                'c.h_inicio AS cronograma_h_inicio',
                'td.sigla AS cronograma_dia_sigla'
            );


        if ($setorFiltro) {
            $queryAssociados->where('s.id', $setorFiltro);
        }
        if ($reuniaoFiltro) {
            $queryAssociados->where('c.id', $reuniaoFiltro);
        }
        if ($membroFiltro) {
            $queryAssociados->where('p.id', $membroFiltro);
        }
        // Adicionar um order by para consistência, se não já tiver um implícito
        $queryAssociados->whereNull('m.dt_fim')->orderBy('p.nome_completo');

        $allAssociates = $queryAssociados->get();

        $allAssociates = $allAssociates->unique(fn($item) => $item->nr_associado . '_' . $item->cronograma_id);
   
        $allAssociateNrs = $allAssociates->pluck('nr_associado')->unique()->filter()->values()->toArray();

        // 2. 🔎 Buscar TODOS os pagamentos relevantes para ESTES associados (SQL Server)
        $allPagamentos = collect();
        if (!empty($allAssociateNrs)) {
            $chunks = collect($allAssociateNrs)->chunk(2000);

            foreach ($chunks as $chunk) {
                $dadosQuery = $sqlsrv->table('movimento_prod_serv AS ms')
                    ->join('movimento AS m', 'm.ordem', 'ms.ordem_movimento')
                    ->join('prod_serv AS ps', 'ms.ordem_prod_serv', 'ps.ordem')
                    ->join('cli_for AS cf', 'm.ordem_cli_for', 'cf.ordem')
                    ->select(
                        'ps.codigo AS codDesc',
                        'ps.nome AS nomeProduto', // nome do produto é a contribuição em si
                        'ms.preco_total_com_desconto AS valor',
                        'cf.codigo AS codigoAssociado'
                    )
                    ->where('m.Efetivado_Financeiro', 1)
                    ->where('m.Desefetivado_Financeiro', 0)
                    ->where('ps.ordem_classe', 10)
                    ->where('cf.fisica_juridica', 'F')
                    ->where('cf.tipo', 'C')
                    ->whereIn('cf.codigo', $chunk);

                if ($anoFiltro) {
                    $dadosQuery->whereRaw("SUBSTRING(ps.codigo, 2, 4) = ?", [$anoFiltro]);
                }

                $allPagamentos = $allPagamentos->merge($dadosQuery->get());
            }
        }

        $indexedPagamentos = $allPagamentos->groupBy('codigoAssociado');


        // 3. 🔄 Processar e Agregar Pagamentos para CADA Associado por Ano/Mês
        $intermediateProcessedMembers = collect();
        foreach ($allAssociates as $assoc) {

            // Se o associado não tiver grupo, setor, cronograma ou dia/hora, pula.
            // Isso evita criar entradas incompletas que podem levar a displays estranhos.
            if (empty($assoc->cronograma_id) || empty($assoc->siglas) || empty($assoc->cronograma_h_inicio) || empty($assoc->cronograma_dia_sigla)) {
                continue;
            }

            $contribuicoesDoAssociado = $indexedPagamentos->get($assoc->nr_associado, collect());
            $contribuicoesPorAnoMes = [];

            foreach ($contribuicoesDoAssociado as $itemPagamento) {
                $cod = $itemPagamento->codDesc;

                if (strlen($cod) >= 7) {
                    $itemAno = substr($cod, 1, 4);
                    $itemMes = substr($cod, 5, 2);
                    $itemValor = (float)$itemPagamento->valor;

                    if (!isset($contribuicoesPorAnoMes[$itemAno])) {
                        // Garante que todos os meses do ano específico estejam presentes, mesmo com 0.0
                        $contribuicoesPorAnoMes[$itemAno] = array_fill_keys(
                            array_map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT), range(1, 12)), 0.0
                        );
                    }

                    if (isset($contribuicoesPorAnoMes[$itemAno][$itemMes])) {
                        $contribuicoesPorAnoMes[$itemAno][$itemMes] += $itemValor;
                    }
                }
            }

            // Apenas adiciona se houve alguma contribuição para *qualquer ano*
            // Ou se queremos mostrar membros sem contribuições (mude a lógica se for o caso)
            if (empty($contribuicoesPorAnoMes)) {
               continue;
            }

            $intermediateProcessedMembers->push([
                'nr_associado' => $assoc->nr_associado,
                'nome_completo' => $assoc->nome_completo,
                'membro_funcao' => $assoc->membro_funcao,
                'nome_grupo' => $assoc->nome_grupo,
                'siglas' => $assoc->siglas,
                'cronograma_id' => $assoc->cronograma_id,
                'cronograma_h_inicio' => $assoc->cronograma_h_inicio,
                'cronograma_dia_sigla' => $assoc->cronograma_dia_sigla,
                'contribuicoes_por_ano_mes' => $contribuicoesPorAnoMes,
            ]);
        }

        // 4. 🏗️ Agrupamento final: Ano ➝ Setor ➝ Reunião (Identificador Único) ➝ Trabalhador
        $finalGroupedData = collect();

        // Pega todos os anos para os quais há contribuições
        $allYearsWithData = $intermediateProcessedMembers
            ->pluck('contribuicoes_por_ano_mes')
            ->flatMap(fn($c) => array_keys($c))
            ->unique()
            ->sortDesc();

        if ($anoFiltro && $allYearsWithData->contains($anoFiltro)) {
            $yearsToDisplay = collect([$anoFiltro]);
        } elseif ($anoFiltro && !$allYearsWithData->contains($anoFiltro)) {
            $yearsToDisplay = collect(); // Nenhum dado para o ano filtrado
        } else {
            $yearsToDisplay = $allYearsWithData; // Todos os anos com dados
        }

        // Contador global para IDs únicos de acordeão de setor
        $globalSectorAccordionIdCounter = 0;

        foreach ($yearsToDisplay as $year) {
            $membersForThisYear = $intermediateProcessedMembers->filter(function ($member) use ($year) {
                // Filtra apenas membros que TÊM dados de contribuição para o ano atual sendo processado
                return isset($member['contribuicoes_por_ano_mes'][$year]) && !empty($member['contribuicoes_por_ano_mes'][$year]);
            });

            if ($membersForThisYear->isEmpty()) {
                continue; // Pula se não houver membros com contribuições para este ano
            }

            // Agrupa os membros por Setor e depois por Reunião (usando nome_grupo + dia_sigla + h_inicio)
            $groupedBySectorAndConceptualReunion = $membersForThisYear->groupBy([
                fn($item) => $item['siglas'] ?? 'Setor Desconhecido',
                // Chave única para a reunião conceitual (id cronograma + nome do grupo + dia + hora)
                fn($item) => ($item['cronograma_id'] ?? 'sem_id') . ' | ' . $item['nome_grupo'] . ' (' . ($item['cronograma_dia_sigla'] ?? 'Dia Desconhecido') . ') | ' . ($item['cronograma_h_inicio'] ?? 'Hora Desconhecida'),
            ]);

            $mappedDataForBlade = collect(); // Inicializa para este ano

            $groupedBySectorAndConceptualReunion->each(function ($reunionsForThisSector, $sectorSigla) use (&$mappedDataForBlade, $year, &$globalSectorAccordionIdCounter) {
                // Gera um ID único para cada contêiner de acordeão de setor, globalmente único na página
                $sectorAccordionContainerId = 'accordionSetor_' . $year . '_' . $globalSectorAccordionIdCounter++;

            $reunionsMapped = $reunionsForThisSector->map(function ($membersInReunion, $conceptualReunionDisplayString) use ($year) {
            $firstMember = $membersInReunion->first();

            $mappedMembers = $membersInReunion->map(function ($member) use ($year) {
                return [
                    'nr_associado' => $member['nr_associado'],
                    'nome_completo' => $member['nome_completo'],
                    'membro_funcao' => $member['membro_funcao'],
                    'contribuicoes' => [
                        $year => $member['contribuicoes_por_ano_mes'][$year]
                    ]
                ];
                 })->values();

            return [
                    'key' => md5(($firstMember['cronograma_id'] ?? '0') . $conceptualReunionDisplayString),
                    'display_name' => $conceptualReunionDisplayString,
                    'members' => $mappedMembers
                    ];
                });

                $mappedDataForBlade->put($sectorSigla, [
                    'container_id' => $sectorAccordionContainerId,
                    'reunions' => $reunionsMapped->values()
                ]);
            });

            $finalGroupedData[$year] = $mappedDataForBlade;
        }

        // 5. 🔁 Paginação dos resultados agrupados
        $totalItems = $finalGroupedData->count();
        $offset = ($currentPage - 1) * $perPage;
        $itemsForCurrentPage = $finalGroupedData->slice($offset, $perPage);

        $paginatedResult = new LengthAwarePaginator(
            $itemsForCurrentPage->all(),
            $totalItems,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );


        // 🧠 Dados auxiliares para os filtros
        $grupo = DB::table('cronograma as c')
            ->leftJoin('grupo AS g', 'c.id_grupo', 'g.id')
            ->leftJoin('setor AS s', 'g.id_setor', 's.id')
            ->leftJoin('tipo_dia AS td', 'c.dia_semana', 'td.id')
            ->whereNull('c.data_fim')
            ->select('g.id AS cid', 'g.nome AS g_nome', 's.sigla AS s_sigla', 'td.sigla AS d_sigla', 'c.h_inicio')
            ->orderBy('g.nome', 'asc')
            ->get();

        $membro = DB::table('membro as m')
            ->leftJoin('associado as a', 'm.id_associado', 'a.id')
            ->leftJoin('pessoas as p', 'a.id_pessoa', 'p.id')
            ->select('m.id', 'p.id as pid', 'p.nome_completo')
            ->distinct('p.nome_completo')
            ->orderBy('p.nome_completo', 'asc')
            ->get();

        $setor = DB::table('setor as s')
            ->select('s.id as sid', 's.nome', 's.sigla')
            ->orderBy('nome', 'asc')
            ->get();


        return view('relatorio.contribuicao-grupo', compact('paginatedResult', 'grupo', 'membro', 'setor'));
    }
}