<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenciarHistoricoCargosRegulares extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idcr)
    {
        $cargoregular = DB::table('cargo_regular')->where('id', $idcr)->first();
        dd($cargoregular);
       $historicocargoregular = DB::table('hist_cargo_regular')
            ->where('id_cargoalterado', $idcr)
            ->get();
        return view('historicocargoregular.gerenciar-hist-cargo-regular',compact('historicocargoregular'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
