<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GerenciarCargosRegularesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargosregulares = DB::table('cargo_regular')
            ->get();


        return view('cargosregulares.gerenciar-cargo-regular',compact('cargosregulares'));
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

        if ($request->input('tipo_cargo') == 1) {
            DB::table('cargo_regular')->insert([
                'nomeCR' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario')
            ]);
        } elseif ($request->input('tipo_cargo') == 2) {
            // Insert different data for tipo_cargo == 2 if needed
            DB::table('cargo_regular')->insert([
                'nomeCC' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario')
                // Add additional fields if needed for tipo_cargo == 2
            ]);
        }
        return redirect()->route('IndexGrenciarCargoRegular');


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
}
