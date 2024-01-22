<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenciarBaseSalarial extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {


        $rel_base_salarial = DB::table('base_salarial')
            ->where('id_funcionario', $idf)
            ->get();

        if ($rel_base_salarial->isEmpty()) {
            return redirect()->route('retornaFormulario', ['idf' => $idf]);
        } else {
            // Add your logic here if needed
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
        $cargo = $request->input('cargo');
        $funcaogratificada = $request->input('funcaog');

        if (empty($funcaogratificada)) {

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
