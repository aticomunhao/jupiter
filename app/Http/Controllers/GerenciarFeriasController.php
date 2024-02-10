<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenciarFeriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ano_referente = Carbon::now()->year - 1;
        $periodo_aquisitivo = DB::table('ferias')
            ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
            ->select(
                'pessoas.nome_completo as nome_completo_funcionario',
                'pessoas.id as id_pessoa',
                'ferias.dt_ini_a',
                'ferias.dt_fim_a',
                'ferias.dt_ini_b',
                'ferias.dt_fim_b',
                'ferias.dt_ini_c',
                'ferias.dt_fim_c',
                'ferias.id as id_ferias',
                'funcionarios.dt_inicio',
                'ferias.ano_de_referencia',
                'ferias.id_funcionario',
                'status_pedido_ferias.id as id_status_pedido_ferias',
                'status_pedido_ferias.nome as status_pedido_ferias'
            )
            ->where('ano_de_referencia', $ano_referente)
            ->get();


        return view('ferias.gerenciar-ferias', compact('periodo_aquisitivo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {

        $ano_referente = Carbon::now()->year - 1;
        $periodo_aquisitivo = DB::table('ferias')
            ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
            ->select(
                'pessoas.nome_completo as nome_completo_funcionario',
                'pessoas.id as id_pessoa',
                'ferias.dt_ini_a',
                'ferias.dt_fim_a',
                'ferias.dt_ini_b',
                'ferias.dt_fim_b',
                'ferias.dt_ini_c',
                'ferias.dt_fim_c',
                'ferias.id as id_ferias',
                'funcionarios.dt_inicio',
                'ferias.ano_de_referencia',
                'ferias.id_funcionario',
                'status_pedido_ferias.id as id_status_pedido_ferias',
                'status_pedido_ferias.nome as status_pedido_ferias'
            )
            ->where('ano_de_referencia', $ano_referente)
            ->where('id_funcionario', $id)
            ->first();

        return view('ferias.incluir-ferias', compact('ano_referente',"periodo_aquisitivo"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function InsereERetornaFuncionarios()
    {
        $data_do_ultimo_ano = Carbon::now()->subYear()->endOfYear()->toDateString();
        $ano_referencia = Carbon::now()->year - 1;

        $funcionarios = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->where('dt_inicio', '<', $data_do_ultimo_ano)
            ->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'funcionarios.dt_inicio as data_de_inicio', 'pessoas.nome_completo')
            ->get();

        foreach ($funcionarios as $funcionario) {
            $data_inicio_periodo_aquisitivo = Carbon::parse($funcionario->data_de_inicio)->copy()->year(Carbon::now()->year - 1)->toDateString();
            $data_fim_periodo_aquisitivo = Carbon::parse($funcionario->data_de_inicio)->copy()->year(Carbon::now()->year)->toDateString();
            $funcionario->data_inicio_periodo_aquisitivo = $data_inicio_periodo_aquisitivo;
            $funcionario->data_fim_periodo_aquisitivo = $data_fim_periodo_aquisitivo;
        }

        $ferias = DB::table('ferias')
            ->where('ano_de_referencia', '=', $ano_referencia)
            ->get();

        if ($ferias->isEmpty()) {
            foreach ($funcionarios as $funcionario) {


                DB::table('ferias')
                    ->insert([
                        'ano_de_referencia' => $ano_referencia,
                        'inicio_periodo_aquisitivo' => $funcionario->data_inicio_periodo_aquisitivo,
                        'fim_periodo_aquisitivo' => $funcionario->data_fim_periodo_aquisitivo,
                        'status_periodo_de_ferias' => 1,
                        'id_funcionario' => $funcionario->id_funcionario

                    ]);
            }
            app('flasher')->addSuccess("Periodo de ferias de " . $ano_referencia . "foi criado");
        } else {
            app('flasher')->addError("Já existe periodo e ferias criado");
        }
        return redirect()->route('IndexGerenciarFerias');
    }
}
