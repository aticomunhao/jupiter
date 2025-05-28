<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Collection;

use App\Models\ViewExterna;

class GerenciarViewsController extends Controller
{
    public function index()
    {

        $grupos =  DB::table('grupo')
            ->leftJoin('setor', 'grupo.id_setor', '=', 'setor.id')
            ->select(
                'grupo.id',
                'grupo.nome',
                // 'grupo.descricao',
                'setor.sigla as nome_setor',
                'setor.id as id_setor'
            )
            ->orderBy('nome')->get();

        // dd($grupos);

        return view('dados_externos.index', compact('grupos'));
    }


    public function show($id)
    {
        // Buscar IDs dos associados do grupo
        $grupo = DB::table('grupo')
            ->join('cronograma', 'grupo.id', '=', 'cronograma.id_grupo')
            ->join('membro', 'membro.id_cronograma', '=', 'cronograma.id')
            ->join('associado', 'associado.id', '=', 'membro.id_associado')
            ->select('associado.id as id_associado')
            ->where('grupo.id', $id)
            ->get();

        // Extrair os IDs em um array simples
        $ids = $grupo->pluck('id_associado')->toArray();

        // Buscar contribuições com nomeProduto processado
        $registros = DB::connection('sqlsrv')
            ->table('ati_v_contribuicoes')
            ->selectRaw("
        codigoAssociado,
        Nome,
        ordemMovimento,
        Data_Cadastro,
        Preco_Total_Com_Desconto,
        nomeProduto,

        -- Limpa o nome após o hífen
        CASE
            WHEN CHARINDEX('-', nomeProduto) > 0
                THEN LTRIM(SUBSTRING(nomeProduto, CHARINDEX('-', nomeProduto) + 1, LEN(nomeProduto)))
            ELSE nomeProduto
        END AS nomeProdutoLimpo,

        -- Detecta se há mês e ano
        CASE
            WHEN nomeProduto LIKE '%JANEIRO %'
              OR nomeProduto LIKE '%FEVEREIRO %'
              OR nomeProduto LIKE '%MARÇO %'
              OR nomeProduto LIKE '%ABRIL %'
              OR nomeProduto LIKE '%MAIO %'
              OR nomeProduto LIKE '%JUNHO %'
              OR nomeProduto LIKE '%JULHO %'
              OR nomeProduto LIKE '%AGOSTO %'
              OR nomeProduto LIKE '%SETEMBRO %'
              OR nomeProduto LIKE '%OUTUBRO %'
              OR nomeProduto LIKE '%NOVEMBRO %'
              OR nomeProduto LIKE '%DEZEMBRO %'
            THEN 1 ELSE 0
        END AS temMesAno,

        -- Extrai o texto do mês e ano
        CASE
            WHEN nomeProduto LIKE '%JANEIRO %' THEN SUBSTRING(nomeProduto, PATINDEX('%JANEIRO %', nomeProduto), 11)
            WHEN nomeProduto LIKE '%FEVEREIRO %' THEN SUBSTRING(nomeProduto, PATINDEX('%FEVEREIRO %', nomeProduto), 13)
            WHEN nomeProduto LIKE '%MARÇO %' THEN SUBSTRING(nomeProduto, PATINDEX('%MARÇO %', nomeProduto), 10)
            WHEN nomeProduto LIKE '%ABRIL %' THEN SUBSTRING(nomeProduto, PATINDEX('%ABRIL %', nomeProduto), 10)
            WHEN nomeProduto LIKE '%MAIO %' THEN SUBSTRING(nomeProduto, PATINDEX('%MAIO %', nomeProduto), 9)
            WHEN nomeProduto LIKE '%JUNHO %' THEN SUBSTRING(nomeProduto, PATINDEX('%JUNHO %', nomeProduto), 10)
            WHEN nomeProduto LIKE '%JULHO %' THEN SUBSTRING(nomeProduto, PATINDEX('%JULHO %', nomeProduto), 10)
            WHEN nomeProduto LIKE '%AGOSTO %' THEN SUBSTRING(nomeProduto, PATINDEX('%AGOSTO %', nomeProduto), 11)
            WHEN nomeProduto LIKE '%SETEMBRO %' THEN SUBSTRING(nomeProduto, PATINDEX('%SETEMBRO %', nomeProduto), 13)
            WHEN nomeProduto LIKE '%OUTUBRO %' THEN SUBSTRING(nomeProduto, PATINDEX('%OUTUBRO %', nomeProduto), 12)
            WHEN nomeProduto LIKE '%NOVEMBRO %' THEN SUBSTRING(nomeProduto, PATINDEX('%NOVEMBRO %', nomeProduto), 13)
            WHEN nomeProduto LIKE '%DEZEMBRO %' THEN SUBSTRING(nomeProduto, PATINDEX('%DEZEMBRO %', nomeProduto), 13)
            ELSE NULL
        END AS nomeProdutoMesAno
    ")
            ->whereIn('codigoAssociado', $ids)
            ->orderBy('codigoAssociado')
            ->orderBy('Data_Cadastro', 'desc')
            ->orderBy('ordemMovimento')
            ->get();

        // Agrupar por associado
        $agrupado = [];

        foreach ($registros as $registro) {
            $codigo = $registro->codigoAssociado;

            if (!isset($agrupado[$codigo])) {
                $agrupado[$codigo] = [
                    'codigoAssociado' => $codigo,
                    'Nome' => $registro->Nome,
                    'contribuicoes' => [],
                ];
            }

            $agrupado[$codigo]['contribuicoes'][] = [
                'ordemMovimento' => $registro->ordemMovimento,
                'Preco_Total_Com_Desconto' => $registro->Preco_Total_Com_Desconto,
                'Data_Cadastro' => $registro->Data_Cadastro,
                'nomeProdutoLimpo' => $registro->nomeProdutoLimpo ?? null,
                'temMesAno' => $registro->temMesAno ?? 0,
                'nomeProdutoMesAno' => $registro->nomeProdutoMesAno ?? null,
            ];
        }

        $contribuicoes_por_associado = $agrupado;

        // Informações do grupo
        $grupo = DB::table('grupo')
            ->leftJoin('setor', 'grupo.id_setor', '=', 'setor.id')
            ->select(
                'grupo.id',
                'grupo.nome',
                'setor.sigla as nome_setor',
                'setor.id as id_setor'
            )
            ->where('grupo.id', $id)
            ->orderBy('nome')
            ->first();
      dd($contribuicoes_por_associado);

        return view('dados_externos.show', compact('grupo', 'contribuicoes_por_associado'));
    }

    public function formulario_consulta(Request $request)
    {
        $grupo = DB::table('grupo')
            ->leftJoin('setor', 'grupo.id_setor', '=', 'setor.id')
            ->select(
                'grupo.id',
                'grupo.nome',
                'setor.sigla as nome_setor',
                'setor.id as id_setor'
            )
            ->where('grupo.id', $request->id_grupo)
            ->orderBy('nome')
            ->first();
        $anos_possiveis = DB::connection('sqlsrv')
            ->table('ati_v_contribuicoes')
            ->select(DB::raw('DISTINCT YEAR(Data_Cadastro) as ano'))
            ->orderBy('ano', 'desc')
            ->get();
        dd($anos_possiveis);


        return view('dados_externos.formulario_consulta', compact('grupo'));
    }
}
