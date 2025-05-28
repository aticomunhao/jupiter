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
            CASE
                WHEN CHARINDEX('-', nomeProduto) > 0
                    THEN LTRIM(SUBSTRING(nomeProduto, CHARINDEX('-', nomeProduto) + 1, LEN(nomeProduto)))
                ELSE nomeProduto
            END AS nomeProdutoLimpo
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
        // dd($contribuicoes_por_associado);

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
