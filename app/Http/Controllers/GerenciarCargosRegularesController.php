<?php

namespace App\Http\Controllers;

use App\Models\pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use File;
use DateTime;
use Illuminate\Support\Facades\Storage;

class GerenciarCargosRegularesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargosregulares = DB::table('cargo_regular')
            ->get();


        return view('cargosregulares.gerenciar-cargo-regular', compact('cargosregulares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('cargosregulares.criar-cargo-regular');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataDeHoje = new DateTime();
        $dataFormatada = $dataDeHoje->format('Y-m-d');

        $request->validate([
            'nomecargo' => 'required|string',
            'data_inicial' => 'required|date',
            'data_final' => 'required|date',
            'salario' => 'required|numeric',
            'tipo_cargo' => 'required|in:1,2',
        ]);

        if ($request->input('data_inicial') > $request->input('data_final')) {
            return redirect()->route('IndexGrenciarCargoRegular')->with('error', 'A data inicial deve ser menor ou igual à data final.');
        }


        if ($request->input('tipo_cargo') == 1) {
            $idcargoregular = DB::table('cargo_regular')->insertGetId([
                'nomeCR' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario')
            ]);

            DB::table('hist_cargo_regular')->insert([
                'id_cargoalterado' => $idcargoregular,
                'dt_alteracao' => $dataFormatada,
                'salarionovo' => $request->input('salario')
            ]);
        } elseif ($request->input('tipo_cargo') == 2) {
            // Insert different data for tipo_cargo == 2 if needed
            $idcargoregular = DB::table('cargo_regular')->insertGetId([
                'nomeCC' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario')
                // Add additional fields if needed for tipo_cargo == 2
            ]);

            DB::table('hist_cargo_regular')->insert([
                'id_cargoalterado' => $idcargoregular,
                'dt_alteracao' => $dataFormatada,
                'salarionovo' => $request->input('salario')
            ]);
        }

        return redirect()->route('IndexGrenciarCargoRegular')->with('success', 'Operação realizada com sucesso.');
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
}
