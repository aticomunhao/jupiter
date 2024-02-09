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

        $periodo_aquisitivo = DB::table('ferias')->get();


        return view('ferias.gerenciar-ferias', compact('periodo_aquisitivo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ferias.incluir-ferias');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
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

        if($ferias->isEmpty()){
            foreach ($funcionarios as $funcionario) {

                DB::table('ferias')
                    ->insert([
                        'ano_de_referencia' => $ano_referencia,
                        'inicio_periodo_aquisitivo' => $funcionario->data_inicio_periodo_aquisitivo,
                        'fim_periodo_aquisitivo' => $funcionario->data_fim_periodo_aquisitivo,
                        'status_periodo_de_ferias' => 1
                    ]);
            }
            app('flasher')->addSuccess("Periodo de ferias de " . $ano_referencia . "foi criado");
        }else{
            app('flasher')->addError("Já existe periodo e ferias criado");
        }
        return redirect()->route('IndexGerenciarFerias');
    }
}
