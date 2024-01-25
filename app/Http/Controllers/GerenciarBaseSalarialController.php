<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class GerenciarBaseSalarialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {


        $hist_base_salarial = DB::table('hist_base_salarial as hist_bs')
            ->join('cargos as cr', 'hist_bs.id_cargo_regular', '=', 'cr.id')
            ->leftJoin('cargos as fg', 'hist_bs.id_funcao_gratificada', '=', 'fg.id')
            ->join('funcionarios as f', 'f.id', '=', 'hist_bs.id_funcionario')
            ->where('hist_bs.id_funcionario', $idf)
            ->select(
                'hist_bs.id as hist_bs_id',
                'hist_bs.data_inicio as hist_bs_dtinicio',
                'hist_bs.data_fim as hist_bs_dtfim',
                'hist_bs.id_funcionario as hist_bs_bsidf',
                'hist_bs.id_funcao_gratificada as hist_bs_idfg',
                'hist_bs.salario_funcao_gratificada as hist_bs_fg_salario',
                'hist_bs.id_cargo_regular as hist_bs_idfg',
                'hist_bs.salario_cargo as hist_bs_cr_salario',
                'cr.nome as crnome',
                'cr.salario as crsalario',
                'fg.nome as fgnome',
                'f.id as fid',
                'f.dt_inicio as fdti'
            )
            ->get();



        if ($hist_base_salarial->isEmpty()) {
            return redirect()->route('retornaFormulario', ['idf' => $idf]);
        } else {
            $salarioatual = DB::table('base_salarial as bs')
                ->leftJoin('cargos as cr', 'bs.cargo', '=', 'cr.id')
                ->leftJoin('cargos as fg', 'bs.funcao_gratificada', '=', 'fg.id')
                ->leftJoin('funcionarios as f', 'f.id', '=', 'bs.id_funcionario')
                ->where('bs.id_funcionario', $idf)
                ->select(
                    'bs.id as bsid',
                    'bs.anuenio as bsanuenio',
                    'bs.dt_inicio as bsdti',
                    'bs.id_funcionario as bsidf',
                    'cr.id as crid',
                    'cr.nome as crnome',
                    'cr.salario as crsalario',
                    'fg.id as fgid',
                    'fg.nome as fgnome',
                    'fg.salario as fgsalario',
                    'f.id as fid',
                    'f.id_pessoa  as fidp',
                    'f.dt_inicio as fdti'
                )->first();

            $funcionario = DB::table('pessoas as p')
                ->where('p.id', $salarioatual->fidp)
                ->join('funcionarios as f', 'f.id_pessoa', '=', 'p.id')
                ->first();


            foreach ($hist_base_salarial as $basesalarials) {
                $dataDeHoje = Carbon::now();
                $dataDaContratacao = Carbon::parse($basesalarials->fdti);
                $basesalarials->anuenio = intval(($dataDeHoje->diffInDays($dataDaContratacao)) / 365);

            }


            return view('basesalarial.gerenciar-base-salarial', compact('hist_base_salarial', 'salarioatual', 'funcionario', 'idf'));

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf, Request $request)
    {
        $input = $request->input("tipocargo");

        if ($input == 1) {
            $cargo = DB::table('cargos')->where('tp_cargo', '=', '1')->where('status', '=', 'true')->get();
            $tp_cargo = DB::table('tp_cargo')->where('idTpCargo', $input)->first();
            return view('basesalarial.cadastrar-base-salarial', compact('cargo', 'idf', 'tp_cargo'));
        } else if ($input == 2) {
            $cargo = DB::table('cargos')->where('tp_cargo', '=', '1')->where('status', '=', 'true')->get();
            $funcaoGratificada = DB::table('cargos')->where('tp_cargo', '=', '2')->where('status', '=', 'true')->get();
            return view('basesalarial.grat-form', compact('cargo', 'idf', 'funcaoGratificada'));
        } else if ($input == 3) {
            $cargo = DB::table('cargos')->where('tp_cargo', '=', '3')->where('status', '=', 'true')->get();
            $tp_cargo = DB::table('tp_cargo')->where('idTpCargo', $input)->first();
            return view('basesalarial.cadastrar-base-salarial', compact('cargo', 'idf', 'tp_cargo'));
        } else if ($input == 4) {
            $cargo = DB::table('cargos')->where('tp_cargo', '=', '4')->where('status', '=', 'true')->get();
            $tp_cargo = DB::table('tp_cargo')->where('idTpCargo', $input)->first();
            return view('basesalarial.cadastrar-base-salarial', compact('cargo', 'idf', 'tp_cargo'));
        }


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idf)
    {

        $dataDeHoje = Carbon::today()->toDateString();
        $input = $request->all();


        $cargo = DB::table('cargos')->where('id', $input['cargo'])->first();


        if ($request->input('funcaog') == null) {
            DB::table('base_salarial')->insert([
                'cargo' => $input['cargo'],
                'funcao_gratificada' => null,
                'dt_inicio' => $dataDeHoje,
                'id_funcionario' => $idf
            ]);

            DB::table('hist_base_salarial')
                ->insert([
                    'id_cargo_regular' => $input['cargo'],
                    'salario_cargo' => $cargo->salario,
                    'data_inicio' => $dataDeHoje,
                    'motivo' => 'Inicio Base Salarial',
                    'id_funcionario' => $idf,
                ]);


        } else {
            $funcaoGratificada = DB::table('cargos')->where('id', $input['funcaog'])->first();

            DB::table('base_salarial')->insert([
                'cargo' => $input['cargo'],
                'funcao_gratificada' => $input['funcaog'],
                'dt_inicio' => $dataDeHoje,
                'id_funcionario' => $idf

            ]);
            DB::table('hist_base_salarial')->insert([
                'id_cargo_regular' => $input['cargo'],
                'salario_cargo' => $cargo->salario,
                'id_funcao_gratificada' => $funcaoGratificada->id,
                'salario_funcao_gratificada' => $funcaoGratificada->salario,
                'data_inicio' => $dataDeHoje,
                'motivo' => 'Inicio Base Salarial',
                'id_funcionario' => $idf,


            ]);


        }
        return redirect()->route('GerenciarBaseSalarialController', ['idf' => $idf]);


    }

    public function retornaFormulario(string $idf)
    {
        $tp_cargo = DB::table('tp_cargo')->get();

        return view('basesalarial.tipo-cargo', compact('tp_cargo', 'idf'));

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
    public function edit(string $idf)

    {

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
        //
    }


}
