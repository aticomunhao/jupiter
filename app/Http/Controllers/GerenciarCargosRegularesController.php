<?php

namespace App\Http\Controllers;

use App\Models\pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use File;
use DateTime;
use Carbon\Carbon;

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
        $dataDeHoje = Carbon::today()->toDateString();

        if ($request->input('data_inicial') > $request->input('data_final') and $request->input('data_final') != null) {
            app('flasher')->addWarning("A data inicial é maior que a data final");
            return redirect()->route('IndexGrenciarCargoRegular');
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
                'dt_alteracao' => $dataDeHoje,
                'salarionovo' => $request->input('salario')
            ]);
        } elseif ($request->input('tipo_cargo') == 2) {
            // Insert different data for tipo_cargo == 2 if needed
            $idcargoregular = DB::table('cargo_regular')->insertGetId([
                'nomeCC' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario')

            ]);
            DB::table('hist_cargo_regular')->insert([
                'id_cargoalterado' => $idcargoregular,
                'dt_alteracao' => $dataDeHoje,
                'salarionovo' => $request->input('salario')
            ]);
        }
        return redirect()->route('IndexGrenciarCargoRegular');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cargoregular = DB::table('cargo_regular')->where('id', $id)->first();
        dd($cargoregular);
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
        //DB::table('')
    }
}
