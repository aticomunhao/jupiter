<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GerenciarCargosController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {



        $cargo = DB::table('cargos as c')
            ->leftJoin('tp_cargo as tp', 'tp.idTpCargo', '=', 'c.tp_cargo')
            ->select('c.id', 'c.nome', 'c.salario', 'c.dt_inicio', 'tp.nomeTpCargo', 'tp.idTpCargo')
            ->get();

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
        $input = $request->all();
        $dataDeHoje = Carbon::today()->toDateString();



        $idCargo = DB::table('cargos')
            ->insertGetId([
                'nome' => $input['nome'] ,
                'salario' => $input['salario'],
                'dt_inicio' => $dataDeHoje,
                'tp_cargo' => $input['tipoCargo'],
                'status' => true
            ]);



        $cargo = DB::table('cargos')
            ->select('cargos.nome')
            ->where('id', $idCargo)
            ->first();

        DB::table('hist_cargo')
            ->insert([
                'salario' => $input['salario'] ?? null,
                'data_inicio' => $dataDeHoje,
                'idcargo' => $idCargo,
                'motivoAlt' => "Primeira Criação do Cargo"
            ]);
        app('flasher')->addSuccess("Cargo $cargo->nome adicionado com sucesso");
        return redirect()->route('gerenciar.cargos');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cargoregular = DB::table('cargos')
            ->where('id', $id)
            ->select('id as idCR', 'nome as nomeCR')
            ->get();
        $hist_cargo_regular = DB::table('hist_cargo')
            ->select('id as idHist', 'salario as salarioHist', 'data_inicio', 'data_fim', 'motivoAlt')
            ->get();


        return view('cargos\visualizar-cargos', compact('cargoregular', 'hist_cargo_regular'));
        //return redirect()->route('vizualizarHistoricoCargo')->with($cargoregular, $hist_cargo_regular);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $cargo = DB::table('cargos')
           ->where('id', $id)
           ->first();
        $tiposCargo = DB::table('tp_cargo')
            ->get();
    
        return view('/cargos/editar-cargos', compact('cargo', 'tiposCargo'));
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
}
