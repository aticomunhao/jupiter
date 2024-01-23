<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class GerenciarBaseSalarial extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {


        $base_salarial = DB::table('base_salarial as bs')
            ->where('bs.id_funcionario', $idf)
            ->join('cargos as cr', 'bs.cargo', '=', 'cr.id')
            ->join('cargos as fg', 'bs.funcao_gratificada', '=', 'fg.id')
            ->join('funcionarios as f', 'f.id', '=', 'bs.id_funcionario')
            ->select('bs.id as bsid', 'bs.anuenio as bsanuenio', 'bs.dt_inicio as bsdti', 'bs.dt_fim as bsdtf',
                'cr.id as crid', 'cr.nome as crnome', 'cr.salario as crsalario',
                'fg.id as fgid', 'fg.nome as fgnome', 'fg.salario as fgsalario',
                'f.id as fid')
            ->get();
        dd($base_salarial);

        if ($base_salarial->isEmpty()) {
            return redirect()->route('retornaFormulario', ['idf' => $idf]);
        } else {
            $salarioatual = DB::table('base_salarial')
                ->where('id_funcionario', $idf)
                ->where('dt_fim', '=', null)
                ->first();

            dd($salarioatual);
            return view('basesalarial.gerenciar-base-salarial', compact('base_salarial', 'salarioatual'));

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

        if ($request->input('funcaog') == null) {
            DB::table('base_salarial')->insert([
                'cargo' => $input['cargo'],
                'funcao_gratificada' => null,
                'dt_inicio' => $dataDeHoje,
                'id_funcionario' => $idf
            ]);
        } else {
            DB::table('base_salarial')->insert([
                'cargo' => $input['cargo'],
                'funcao_gratificada' => $input['funcaog'],
                'dt_inicio' => $dataDeHoje,
                'id_funcionario' => $idf
            ]);

            return redirect()->route('GerenciarBaseSalarial', ['idf' => $idf]);
        }


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
        //
    }

    public function retornaFormulario(string $idf)
    {
        $tp_cargo = DB::table('tp_cargo')->get();

        return view('basesalarial.tipo-cargo', compact('tp_cargo', 'idf'));

    }
}
