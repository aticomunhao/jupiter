<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GerenciarCargos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pesquisa = request('pesquisa');

        if ($pesquisa) {
            $cargo = DB::table('cargos')
            ->join('tp_cargo', 'tp_cargo.idTpCargo', '=', 'cargos.id' )
            ->select('cargos.id','cargos.nome', 'cargos.salario','cargos.dt_inicio','tp_cargo.nomeTpCargo' )
            ->where('cargos.nome', 'ilike', '%' . $pesquisa . '%')
            ->get();
        } else {
            $cargo = DB::table('cargos')
            ->join('tp_cargo', 'tp_cargo.idTpCargo', '=', 'cargos.id' )
            ->select('cargos.id','cargos.nome', 'cargos.salario','cargos.dt_inicio','tp_cargo.nomeTpCargo' )
            ->get();
        }






        return view('cargos.gerenciar-cargos', compact('cargo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposCargo = DB::table('tp_cargo')
           ->get();

        return view('cargos.incluir-cargos', compact('tiposCargo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return view('/cargos/editar-cargos');
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
