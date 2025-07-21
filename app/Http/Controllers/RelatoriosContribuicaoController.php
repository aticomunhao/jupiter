<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection; // Certifique-se de importar Collection
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class RelatoriosContribuicaoController extends Controller
{
    private const IDEAL_VALUE = 80.00; 

    private function montarDadosRelatorio(Request $request)
    {
     //  Conexões
        $pgsql = DB::connection('pgsql');
        $sqlsrv = DB::connection('sqlsrv');


        //  Filtros
        $setorFiltro = $request->input('setor');
        $reuniaoFiltro = $request->input('reuniao');
        $membroFiltro = $request->input('membro');
        $anoFiltro = $request->input('anoFiltro');

        //  Paginação dos resultados FINAIS AGRUPADOS (por ano)
        $perPage = 5; // Ajuste este valor conforme necessário
        $currentPage = $request->get('page', 1);

        // 1. Buscar TODOS os associados relevantes (PostgreSQL)
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
            $queryAssociados->where('m.id', $membroFiltro);
        }
        // Adicionar um order by para consistência, se não já tiver um implícito
        $queryAssociados->whereNull('m.dt_fim')->orderBy('p.nome_completo');

        $allAssociates = $queryAssociados->get();

        $allAssociates = $allAssociates->unique(fn($item) => $item->nr_associado . '_' . $item->cronograma_id);
   
        $allAssociateNrs = $allAssociates->pluck('nr_associado')->unique()->filter()->values()->toArray();

        
        // 2. Buscar TODOS os pagamentos relevantes para ESTES associados (SQL Server)
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

                if (!empty($anoFiltro)) {
                    $dadosQuery->whereRaw("SUBSTRING(ps.codigo, 2, 4) = ?", [$anoFiltro]);

                }

                $allPagamentos = $allPagamentos->merge($dadosQuery->get());
            }
        }


        $indexedPagamentos = $allPagamentos->groupBy('codigoAssociado');


        // 3.  Processar e Agregar Pagamentos para CADA Associado por Ano/Mês
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
                    $contribuicoesPorAnoMes[$anoFiltro] = array_fill_keys(
                    array_map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT), range(1, 12)),
                    0.0
                );
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

        // 5.  Paginação dos resultados agrupados
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


        //  Dados auxiliares para os filtros
        $grupo = DB::table('cronograma as c')
            ->leftJoin('grupo AS g', 'c.id_grupo', 'g.id')
            ->leftJoin('setor AS s', 'g.id_setor', 's.id')
            ->leftJoin('tipo_dia AS td', 'c.dia_semana', 'td.id')
            ->whereNull('c.data_fim')
            ->select('c.id AS cid', 'g.nome AS g_nome', 's.sigla AS s_sigla', 'td.sigla AS d_sigla', 'c.h_inicio')
            ->orderBy('g.nome', 'asc')
            ->get();

        $membro = DB::table('membro as m')
            ->leftJoin('associado as a', 'm.id_associado', 'a.id')
            ->leftJoin('pessoas as p', 'a.id_pessoa', 'p.id')
            ->select('m.id', 'p.id as pid', 'p.nome_completo')
            ->orderBy('p.nome_completo', 'asc')
            ->get();

        $setor = DB::table('setor as s')
            ->select('s.id as sid', 's.nome', 's.sigla')
            ->orderBy('nome', 'asc')
            ->get();

        return [
            'paginatedResult' => $paginatedResult,
            'grupo' => $grupo,
            'membro' => $membro,
            'setor' => $setor,
            'anoFiltro' => $anoFiltro,
        ];
    }

    public function index(Request $request)
    {

        // Conexões
    $pgsql = DB::connection('pgsql');
    $sqlsrv = DB::connection('sqlsrv');

    // Filtros
    $setorFiltro = $request->input('setor');
    $reuniaoFiltro = $request->input('reuniao');
    $membroFiltro = $request->input('membro');
    $anoFiltro = $request->input('anoFiltro') ?? date('Y');

    // Paginação de setores dentro do ano
    $perPage = 3;
    $currentPage = $request->get('page', 1);

    // 1. Buscar associados
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
        )
        ->whereNull('m.dt_fim')
        ->orderBy('p.nome_completo');

    if ($setorFiltro) {
        $queryAssociados->where('s.id', $setorFiltro);
    }
    if ($reuniaoFiltro) {
        $queryAssociados->where('c.id', $reuniaoFiltro);
    }
    if ($membroFiltro) {
        $queryAssociados->where('m.id', $membroFiltro);
    }

    $allAssociates = $queryAssociados->get()
        ->unique(fn($item) => $item->nr_associado . '_' . $item->cronograma_id);

    $allAssociateNrs = $allAssociates->pluck('nr_associado')->unique()->filter()->values()->toArray();

    // 2. Buscar pagamentos
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
                    'ps.nome AS nomeProduto',
                    'ms.preco_total_com_desconto AS valor',
                    'cf.codigo AS codigoAssociado',
                    'cf.comentarios'
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

    // 3. Processamento
    $intermediateProcessedMembers = collect();
    foreach ($allAssociates as $assoc) {
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
                    $contribuicoesPorAnoMes[$itemAno] = array_fill_keys(
                        array_map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT), range(1, 12)), 0.0
                    );
                }

                if (isset($contribuicoesPorAnoMes[$itemAno][$itemMes])) {
                    $contribuicoesPorAnoMes[$itemAno][$itemMes] += $itemValor;
                }
            }
        }

        // Se não tiver contribuições no ano, preenche com 0.0
        if (empty($contribuicoesPorAnoMes)) {
            $contribuicoesPorAnoMes[$anoFiltro] = array_fill_keys(
                array_map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT), range(1, 12)),
                0.0
            );
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

   // 4. Agrupamento por setor dentro do anoFiltro (mantendo agrupamento por ano)
$membersForThisYear = $intermediateProcessedMembers->filter(fn($m) =>
    isset($m['contribuicoes_por_ano_mes'][$anoFiltro])
);

$groupedBySectorAndReuniao = $membersForThisYear->groupBy([
    fn($m) => $m['siglas'] ?? 'Setor Desconhecido',
    fn($m) => ($m['cronograma_id'] ?? 'sem_id') . ' | ' . $m['nome_grupo'] . ' (' . ($m['cronograma_dia_sigla'] ?? '-') . ') | ' . ($m['cronograma_h_inicio'] ?? '-')
]);

$finalGroupedData = [];
$globalSectorAccordionIdCounter = 0;

$groupedBySectorAndReuniao->each(function ($reunioes, $setorSigla) use (&$finalGroupedData, &$globalSectorAccordionIdCounter, $anoFiltro) {
    $containerId = 'accordionSetor_' . $anoFiltro . '_' . $globalSectorAccordionIdCounter++;

    $reunionsMapped = $reunioes->map(function ($membros, $reuniaoNome) use ($anoFiltro) {
        $first = $membros->first();
        $mapped = $membros->map(fn($m) => [
            'nr_associado' => $m['nr_associado'],
            'nome_completo' => $m['nome_completo'],
            'membro_funcao' => $m['membro_funcao'],
            'contribuicoes' => [
                $anoFiltro => $m['contribuicoes_por_ano_mes'][$anoFiltro] ?? []
            ]
        ])->values();

        return [
            'key' => md5(($first['cronograma_id'] ?? '0') . $reuniaoNome),
            'display_name' => $reuniaoNome,
            'members' => $mapped
        ];
    });

    $finalGroupedData[$anoFiltro][$setorSigla] = [
        'container_id' => $containerId,
        'reunions' => $reunionsMapped->values()
    ];
});

    //6. Paginar apenas os setores do ano selecionado
$setoresParaPaginar = collect($finalGroupedData[$anoFiltro] ?? []);
$totalItems = $setoresParaPaginar->count();
$offset = ($currentPage - 1) * $perPage;
$itemsForCurrentPage = $setoresParaPaginar->slice($offset, $perPage);

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
    // 7. Filtros auxiliares
    $grupo = DB::table('cronograma as c')
        ->leftJoin('grupo AS g', 'c.id_grupo', 'g.id')
        ->leftJoin('setor AS s', 'g.id_setor', 's.id')
        ->leftJoin('tipo_dia AS td', 'c.dia_semana', 'td.id')
        ->whereNull('c.data_fim')
        ->select('c.id AS cid', 'g.nome AS g_nome', 's.sigla AS s_sigla', 'td.sigla AS d_sigla', 'c.h_inicio')
        ->orderBy('g.nome', 'asc')
        ->get();

    $membro = DB::table('membro as m')
        ->leftJoin('associado as a', 'm.id_associado', 'a.id')
        ->leftJoin('pessoas as p', 'a.id_pessoa', 'p.id')
        ->select('m.id', 'p.id as pid', 'p.nome_completo')
        ->orderBy('p.nome_completo', 'asc')
        ->get();

    $setor = DB::table('setor as s')
        ->select('s.id as sid', 's.nome', 's.sigla')
        ->orderBy('nome', 'asc')
        ->get();

    // 8. Montagem final
    $dados = [
        'paginatedResult' => $paginatedResult,
        'grupo' => $grupo,
        'membro' => $membro,
        'setor' => $setor,
        'anoFiltro' => $anoFiltro,
    ];

    return view('relatorio.contribuicao-grupo', $dados);
    }

    public function gerarPdf(Request $request){

         $dados = $this->montarDadosRelatorio($request);

        $pdf = PDF::loadView('gerar-pdf.contribuicao-grupo', $dados)
            ->setPaper('a4', 'landscape');

        return $pdf->download('lista_associados.pdf');
    

    }

    public function estatistica(Request $request)
    {
            $pgsql = DB::connection('pgsql');
            $sqlsrv = DB::connection('sqlsrv');

            $mesAtual = intval(date('m'))-1;
            $setorFiltro = $request->input('setor');
            $reuniaoFiltro = $request->input('reuniao');
            $membroFiltro = $request->input('membro');
            $anoFiltro = $request->input('anoFiltro');
            $perPage = 3;
            $currentPage = $request->get('page', 1);
            $valorIdealMensal = 80.00;

            // Utilitário para extrair valor previsto dos comentários
            function extrairValorPrevisto($comentarios)
            {
                if (!$comentarios) return null;

                if (preg_match('/\/\s*\$([\d.,]+)\$\s*\//', $comentarios, $matches) ||
                    preg_match('/\$([\d.,]+)\$/', $comentarios, $matches)) {

                    $valor = str_replace(['.', ','], ['', '.'], $matches[1]);
                    return floatval($valor);
                }

                Log::warning("Valor previsto não extraído. Comentários: " . $comentarios);
                return null;
            }

            // Verifica isenção de contribuição

            function verificarIsencao($comentarios, $anoFiltro)
            {
                // Sempre "Sim" se for isento fixo
                if (stripos($comentarios, 'ISENTO_FIXO') !== false) {
                    return 'Sim';
                }

                // Ex: ISENTO: 1202507-1202410 (com espaço após :)
                if (preg_match_all('/ISENTO:\s*(\d{7})-(\d{7})/i', $comentarios, $matches, PREG_SET_ORDER)) {
                    $hoje = Carbon::now()->startOfMonth();

                    foreach ($matches as $match) {
                        $raw1 = $match[1]; // pode ser início ou fim
                        $raw2 = $match[2];

                        // Extrai ano e mês
                        $ano1 = intval(substr($raw1, 1, 4));
                        $mes1 = intval(substr($raw1, 5, 2));
                        $data1 = Carbon::create($ano1, $mes1, 1)->startOfMonth();

                        $ano2 = intval(substr($raw2, 1, 4));
                        $mes2 = intval(substr($raw2, 5, 2));
                        $data2 = Carbon::create($ano2, $mes2, 1)->startOfMonth();

                        // Define intervalo
                        $inicio = $data1->lt($data2) ? $data1 : $data2;
                        $fim = $data1->gt($data2) ? $data1 : $data2;

                        // Verifica se o mês atual está no intervalo
                        if ($hoje->between($inicio, $fim)) {
                            return 'Parcial';
                        }
                    }
                }

                return 'Não';
            }

            // Consulta principal dos associados
            $query = $pgsql->table('associado AS a')
                ->leftJoin('membro AS m', 'a.id', '=', 'm.id_associado')
                ->leftJoin('tipo_funcao AS tf', 'm.id_funcao', '=', 'tf.id')
                ->leftJoin('cronograma AS c', 'm.id_cronograma', '=', 'c.id')
                ->leftJoin('grupo AS g', 'c.id_grupo', '=', 'g.id')
                ->leftJoin('pessoas AS p', 'a.id_pessoa', '=', 'p.id')
                ->leftJoin('setor AS s', 'g.id_setor', '=', 's.id')
                ->leftJoin('tipo_dia AS td', 'c.dia_semana', '=', 'td.id')
                ->select(
                    'a.nr_associado',
                    'p.nome_completo',
                    'tf.nome AS membro_funcao',
                    'g.nome AS nome_grupo',
                    's.sigla AS sigla_setor',
                    'c.id AS cronograma_id',
                    'c.h_inicio',
                    'td.sigla AS dia_sigla'
                )
                ->whereNull('m.dt_fim')
                ->whereNotNull('g.id');

            if ($setorFiltro) $query->where('s.id', $setorFiltro);
            if ($reuniaoFiltro) $query->where('c.id', $reuniaoFiltro);
            if ($membroFiltro) $query->where('m.id', $membroFiltro);

            $associados = $query->get()->unique(fn ($a) => $a->nr_associado . '_' . $a->cronograma_id);

            // Padronizar código dos associados
            $codigos = $associados->pluck('nr_associado')->unique()->filter()->values()->toArray();

            // Comentários dos cadastros
            $comentariosIndividuais = collect();
            if (!empty($codigos)) {
                foreach (array_chunk($codigos, 2000) as $chunk) {
                    $comentariosIndividuais = $comentariosIndividuais->merge(
                        $sqlsrv->table('cli_for')
                            ->select('codigo', 'comentarios')
                            ->where('fisica_juridica', 'F')
                            ->where('tipo', 'C')
                            ->whereIn('codigo', $chunk)
                            ->get()
                    );
                }
            }
            $comentariosIndexados = $comentariosIndividuais->keyBy('codigo');

            // Pagamentos incluindo valor 0 ou NULL
            $pagamentos = collect();
            if (!empty($codigos)) {
                foreach (array_chunk($codigos, 2000) as $chunk) {
                    $pagamentos = $pagamentos->merge(
                        $sqlsrv->table('movimento_prod_serv AS ms')
                            ->join('movimento AS m', 'm.ordem', '=', 'ms.ordem_movimento')
                            ->join('prod_serv AS ps', 'ms.ordem_prod_serv', '=', 'ps.ordem')
                            ->join('cli_for AS cf', 'm.ordem_cli_for', '=', 'cf.ordem')
                            ->select(
                                'ps.codigo AS codDesc',
                                'ms.preco_total_com_desconto AS valor',
                                'cf.codigo AS codigoAssociado',
                                'cf.comentarios'
                            )
                            ->where('m.Efetivado_Financeiro', 1)
                            ->where('m.Desefetivado_Financeiro', 0)
                            ->where('ps.ordem_classe', 10)
                            ->where('cf.fisica_juridica', 'F')
                            ->where('cf.tipo', 'C')
                            ->whereIn('cf.codigo', $chunk)
                            ->where(function ($q) {
                                $q->whereNull('ms.preco_total_com_desconto')
                                ->orWhere('ms.preco_total_com_desconto', 0)
                                ->orWhere('ms.preco_total_com_desconto', '>', 0);
                            })
                            ->when($anoFiltro, fn ($q) => $q->whereRaw("SUBSTRING(ps.codigo, 2, 4) = ?", [$anoFiltro]))
                            ->get()
                    );
                }
            }


            $pagamentosIndexados = $pagamentos->groupBy('codigoAssociado');
            $dadosAgrupados = [];
            $contadorGlobal = 1;

            foreach ($associados as $assoc) {
                $totalGeralArrecadado = 0;
                $totalGeralIdeal = 0;
                $totalGeralPrevisto = 0;

                $dadosAgrupados = [];
                $contadorGlobal = 1;

                foreach ($associados as $assoc) {
                    $ano = $anoFiltro;
                    $setor = $assoc->sigla_setor ?? 'SEM SETOR';
                    $reuniaoKey = md5($assoc->nome_grupo . $assoc->h_inicio . $assoc->dia_sigla);
                    $nr = (string) $assoc->nr_associado;

                    $pagamentosAssoc = $pagamentosIndexados->get($nr, collect());
                    $comentariosCadastro = optional($comentariosIndexados->get($nr))->comentarios;

                    $contribuicoesMensais = array_fill_keys(
                        array_map(fn ($m) => str_pad($m, 2, '0', STR_PAD_LEFT), range(1, 12)),
                        0.0
                    );

                    $comentariosConcat = $pagamentosAssoc->pluck('comentarios')->implode(' ');
                    if (empty(trim($comentariosConcat))) {
                        $comentariosConcat = $comentariosCadastro ?? '';
                    }

                    $isentoStatus = verificarIsencao($comentariosConcat, $anoFiltro);
                    $valorPrevistoOriginal = extrairValorPrevisto($comentariosConcat) ?? 0;

                    foreach ($pagamentosAssoc as $pag) {
                        if (strlen($pag->codDesc) >= 7) {
                                $mes = substr($pag->codDesc, 5, 2);
                                if (isset($contribuicoesMensais[$mes])) {
                                    $contribuicoesMensais[$mes] += floatval($pag->valor);
                                }
                            }
                        }

                    $mesesContribuidos = 0;

                    for ($i = 1; $i <= $mesAtual; $i++) {
                        $mesStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                        if (!empty($contribuicoesMensais[$mesStr]) && $contribuicoesMensais[$mesStr] > 0) {
                            $mesesContribuidos++;
                        }
                    }

                    $total = array_sum($contribuicoesMensais);
                    $valorPrevisto = $valorPrevistoOriginal ? $valorPrevistoOriginal * $mesAtual : null;
                    $valorIdealParcial = $valorIdealMensal * $mesAtual;
                    $mesesAtrasados = $mesAtual - $mesesContribuidos;

                    $percentIdeal = $valorIdealParcial > 0
                        ? round(($total / $valorIdealParcial) * 100, 1)
                        : null;

                    $percentPrev = $valorPrevisto > 0
                        ? round(($total / $valorPrevisto) * 100, 1)
                        : null;

                    // Acumulando para total geral
                    $totalGeralArrecadado += $total;
                    $totalGeralIdeal += $valorIdealParcial;
                    if ($valorPrevisto !== null) {
                        $totalGeralPrevisto += $valorPrevisto;
                    }

                    $dadosAgrupados[$ano][$setor]['container_id'] = "acc_" . md5($setor . $ano);
                    $dadosAgrupados[$ano][$setor]['reunions'][$reuniaoKey]['display_name'] =
                        "{$assoc->nome_grupo} ({$assoc->sigla_setor}) | {$assoc->dia_sigla} | {$assoc->h_inicio}";
                    $dadosAgrupados[$ano][$setor]['reunions'][$reuniaoKey]['key'] = $reuniaoKey;

                    $dadosAgrupados[$ano][$setor]['reunions'][$reuniaoKey]['members'][] = [
                        'codigo_associado' => $assoc->nr_associado,
                        'isento' => $isentoStatus,
                        'sequencial' => $contadorGlobal++,
                        'contribuicoes' => [$ano => $contribuicoesMensais],
                        'resumo_ano' => [
                            'total_arrecadado' => $total,
                            'valor_ideal' => $valorIdealParcial,
                            'valor_previsto' => $valorPrevisto,
                            'meses_atrasados' => $mesesAtrasados,
                            'percentual_ideal' => $percentIdeal,
                            'percentual_previsto' => $percentPrev,
                        ],
                    ];
                }

            // Calcular percentuais gerais
            $percentualGeralIdeal = $totalGeralIdeal > 0
                ? round(($totalGeralArrecadado / $totalGeralIdeal) * 100, 1)
                : null;

            $percentualGeralPrevisto = $totalGeralPrevisto > 0
                ? round(($totalGeralArrecadado / $totalGeralPrevisto) * 100, 1)
                : null;

            // Paginação
            $setoresFlattened = collect();
            foreach ($dadosAgrupados as $ano => $setoresAgrupados) {
                foreach ($setoresAgrupados as $setor => $conteudo) {
                    $setoresFlattened->push([
                        'ano' => $ano,
                        'setor' => $setor,
                        'container_id' => $conteudo['container_id'],
                        'reunions' => $conteudo['reunions']
                    ]);
                }
            }

            $total = $setoresFlattened->count();
            $paginatedSetores = $setoresFlattened->forPage($currentPage, $perPage);

            $setores = DB::table('setor as s')
                        ->select('s.id as sid', 's.nome', 's.sigla')
                        ->orderBy('nome', 'asc')
                        ->get();

            $reunioes = DB::table('cronograma as c')
                        ->leftJoin('grupo AS g', 'c.id_grupo', 'g.id')
                        ->leftJoin('setor AS s', 'g.id_setor', 's.id')
                        ->leftJoin('tipo_dia AS td', 'c.dia_semana', 'td.id')
                        ->whereNull('c.data_fim')
                        ->select('c.id AS cid', 'g.nome AS g_nome', 's.sigla AS s_sigla', 'td.sigla AS d_sigla', 'c.h_inicio')
                        ->orderBy('g.nome', 'asc')
                        ->get();

            $paginatedResult = new LengthAwarePaginator(
                $paginatedSetores,
                $total,
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );

            $dadosGrafico = [];

        foreach ($dadosAgrupados as $ano => $setoresAgrupados) {
            foreach ($setoresAgrupados as $setor => $conteudo) {
                foreach ($conteudo['reunions'] as $reuniaoKey => $reuniao) {
                    $nomeGrupo = $reuniao['display_name'];
                    $totalGrupo = 0;

                    foreach ($reuniao['members'] as $m) {
                        $totalGrupo += $m['resumo_ano']['total_arrecadado'];
                    }

                    $dadosGrafico[] = [
                        'grupo' => $nomeGrupo,
                        'valor' => round($totalGrupo, 2)
                    ];
                }
            }
        }

        // Tabela 1 – Isenção
        $totalAssociados = 0;
        $qtdeIsentos = [
            'Sim' => 0,
            'Parcial' => 0,
            'Não' => 0
        ];

        // Tabela 2 – Contribuição x Ideal
        $contribuicaoVsIdeal = [
            'zero' => 0,
            'abaixo' => 0,
            'igual' => 0,
            'acima' => 0
        ];

        foreach ($dadosAgrupados as $ano => $setoresAgrupados) {
            foreach ($setoresAgrupados as $setor => $conteudo) {
                foreach ($conteudo['reunions'] as $reuniao) {
                    foreach ($reuniao['members'] as $membro) {
                        $totalAssociados++;

                        // Contagem de isentos
                        $isento = $membro['isento'] ?? 'Não';
                        if (isset($qtdeIsentos[$isento])) {
                            $qtdeIsentos[$isento]++;
                        }

                        // Contagem por faixa de contribuição
                        $totalArrecadado = $membro['resumo_ano']['total_arrecadado'] ?? 0;
                        $valorIdeal = $membro['resumo_ano']['valor_ideal'] ?? 0;

                        if ($totalArrecadado == 0) {
            $contribuicaoVsIdeal['zero']++;
        } elseif ($valorIdeal == 0) {
            // Valor ideal 0 mas houve contribuição positiva — considera como "acima"
            $contribuicaoVsIdeal['acima']++;
        } elseif ($totalArrecadado < $valorIdeal) {
            $contribuicaoVsIdeal['abaixo']++;
        } elseif ($totalArrecadado == $valorIdeal) {
            $contribuicaoVsIdeal['igual']++;
        } else {
            $contribuicaoVsIdeal['acima']++;
        }
                    }
                }
            }
        }


            return view('relatorio.estatistica-grupo', compact(
            'paginatedResult',
            'setores',
            'reunioes',
            'valorIdealParcial',
            'totalGeralArrecadado',
            'totalGeralIdeal',
            'totalGeralPrevisto',
            'percentualGeralIdeal',
            'percentualGeralPrevisto',
            'mesAtual', 
            'dadosGrafico',
            'totalAssociados',
            'qtdeIsentos',
            'contribuicaoVsIdeal'
            ));

        }
    }

   public function geral(Request $request)
    {
        

        $anoFiltro = $request->input('anoFiltro') ?? date('Y');
        $mesFiltro = $request->input('mes');

        $sqlsrv = DB::connection('sqlsrv');

        $associados = $sqlsrv->table('cli_for')
            ->select('codigo', 'comentarios')
            ->where('fisica_juridica', 'F')
            ->where('tipo', 'C')
            ->whereRaw('CAST(codigo AS INT) < 50000')
            ->whereYear('data_cadastro', '<=', $anoFiltro)
            ->get();

        $pagamentosQuery = $sqlsrv->table('movimento_prod_serv AS ms')
            ->join('movimento AS m', 'm.ordem', '=', 'ms.ordem_movimento')
            ->join('prod_serv AS ps', 'ms.ordem_prod_serv', '=', 'ps.ordem')
            ->join('cli_for AS cf', 'm.ordem_cli_for', '=', 'cf.ordem')
            ->select(
                'cf.codigo AS codigoAssociado',
                'ms.preco_total_com_desconto AS valor',
                'ps.codigo AS codDesc'
            )
            ->where('m.Efetivado_Financeiro', 1)
            ->where('m.Desefetivado_Financeiro', 0)
            ->where('ps.ordem_classe', 10)
            ->where('cf.fisica_juridica', 'F')
            ->where('cf.tipo', 'C')
            ->whereRaw('CAST(cf.codigo AS INT) < 50000');

        $pagamentosQuery->when($anoFiltro, function ($q, $ano) {
            $q->whereRaw("SUBSTRING(ps.codigo, 2, 4) = ?", [$ano]);
        });

        $pagamentosQuery->when($mesFiltro, function ($q, $mes) {
            $paddedMes = str_pad($mes, 2, '0', STR_PAD_LEFT);
            $q->whereRaw("SUBSTRING(ps.codigo, 6, 2) = ?", [$paddedMes]);
        });

        $pagamentos = $pagamentosQuery->get();

        $pagos = [];
        foreach ($pagamentos as $pagamento) {
            $cod = $pagamento->codigoAssociado;
            $valor = (float) $pagamento->valor;
            $pagos[$cod] = ($pagos[$cod] ?? 0) + $valor;
        }

        $contribuicaoVsIdeal = [
            'zero' => 0,
            'abaixo' => 0,
            'igual' => 0,
            'acima' => 0,
        ];

        $qtdeIsentos = [
            'Sim' => 0,
            'Parcial' => 0,
            'Não' => 0,
        ];

        $totalGeralPrevisto = 0;

        foreach ($associados as $assoc) {
            $codigo = $assoc->codigo;
            $valorPago = $pagos[$codigo] ?? 0;

            if ($valorPago == 0) {
                $contribuicaoVsIdeal['zero']++;
            } elseif ($valorPago < self::IDEAL_VALUE) {
                $contribuicaoVsIdeal['abaixo']++;
            } elseif (abs($valorPago - self::IDEAL_VALUE) < PHP_FLOAT_EPSILON) {
                $contribuicaoVsIdeal['igual']++;
            } else {
                $contribuicaoVsIdeal['acima']++;
            }

            $tipoIsencao = $this->verificarIsencao($assoc->comentarios, $anoFiltro);
            $qtdeIsentos[$tipoIsencao]++;

            $previsto = $this->extrairValorPrevisto($assoc->comentarios);
            if ($previsto !== null) {
                $totalGeralPrevisto += $previsto;
            }
        }

        $totalAssociados = count($associados);
        $totalGeralIdeal = $totalAssociados * self::IDEAL_VALUE;
        $totalGeralArrecadado = array_sum($pagos);

        $percentualGeralIdeal = $totalGeralIdeal > 0
            ? round(($totalGeralArrecadado / $totalGeralIdeal) * 100, 2)
            : null;

        $percentualGeralPrevisto = $totalGeralPrevisto > 0
            ? round(($totalGeralArrecadado / $totalGeralPrevisto) * 100, 2)
            : null;

        return view('relatorio.estatistica-geral', [
            'totalAssociados' => $totalAssociados,
            'qtdeIsentos' => $qtdeIsentos,
            'contribuicaoVsIdeal' => $contribuicaoVsIdeal,
            'totalGeralArrecadado' => $totalGeralArrecadado,
            'totalGeralIdeal' => $totalGeralIdeal,
            'totalGeralPrevisto' => $totalGeralPrevisto,
            'percentualGeralIdeal' => $percentualGeralIdeal,
            'percentualGeralPrevisto' => $percentualGeralPrevisto,
        ]);
    }

    private function verificarIsencao($comentarios, $anoFiltro)
    {
if (!$comentarios) {
        return 'Não';
    }

    if (stripos($comentarios, 'ISENTO_FIXO') !== false) {
        return 'Sim';
    }

    // Regex ajustada para capturar DYYYYMM. Ex: ISENTO:1202301-1202412
    // Captura: 1º dígito (D), Ano (AAAA), Mês (MM) para cada data.
    if (preg_match_all('/ISENTO: \s*\d(\d{4})(\d{2})-\d(\d{4})(\d{2})/i', $comentarios, $matches, PREG_SET_ORDER)) {
        // Criamos uma data no início do ano do filtro para usar na comparação
        $anoAtualData = Carbon::createFromDate($anoFiltro, 1, 1)->startOfYear();

        foreach ($matches as $match) {
            // $match[1] é o ano da primeira data, $match[2] é o mês da primeira data
            $ano1 = (int) $match[1];
            $mes1 = (int) $match[2];
            $data1 = Carbon::create($ano1, $mes1, 1)->startOfMonth();

            // $match[3] é o ano da segunda data, $match[4] é o mês da segunda data
            $ano2 = (int) $match[3];
            $mes2 = (int) $match[4];
            $data2 = Carbon::create($ano2, $mes2, 1)->startOfMonth();

            // Garantir que $inicio é a data menor e $fim é a data maior
            $inicio = $data1->min($data2);
            $fim = $data1->max($data2);

            // Verifica se o ano atual (do filtro) está dentro do período de isenção
            if ($anoAtualData->between($inicio, $fim)) {
                return 'Parcial';
            }
        }
    }

    return 'Não';    }

    private function extrairValorPrevisto($comentarios)
    {
        if (!$comentarios) return null;

        if (preg_match('/\/\s*\$([\d.,]+)\$\s*\//', $comentarios, $matches) ||
            preg_match('/\$([\d.,]+)\$/', $comentarios, $matches)) {

            $valor = str_replace(['.', ','], ['', '.'], $matches[1]);
            return floatval($valor);
        }

        Log::warning("Valor previsto não extraído. Comentários: " . $comentarios);
        return null;
    }
   
}