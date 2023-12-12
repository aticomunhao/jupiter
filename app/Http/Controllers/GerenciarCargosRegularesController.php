<?php

namespace App\Http\Controllers;

use App\Models\pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use DateTime;
use Carbon\Carbon;

class GerenciarCargosRegularesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cargosregulares = DB::table('cargo_regular')->orderBy('nomeCR')
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
            return redirect()->route('IndexGerenciarCargoRegular');
        }

        if ($request->input('tipo_cargo') == 1) {
            $idcargoregular = DB::table('cargo_regular')->insertGetId([
                'nomeCR' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario'),
                'nomeCC' => null
            ]);
            DB::table('hist_cargo_regular')->insert([
                'id_cargoalterado' => $idcargoregular,
                'dt_alteracao' => $dataDeHoje,
                'salarionovo' => $request->input('salario'),
                'motivoalt' => 'Criacao do Cargo Regular'
            ]);
        } elseif ($request->input('tipo_cargo') == 2) {
            // Insert different data for tipo_cargo == 2 if needed
            $idcargoregular = DB::table('cargo_regular')->insertGetId([
                'nomeCC' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario'),
                'nomeCR' => null
            ]);
            DB::table('hist_cargo_regular')->insert([
                'id_cargoalterado' => $idcargoregular,
                'dt_alteracao' => $dataDeHoje,
                'salarionovo' => $request->input('salario'),
                'motivoalt' => 'Criacao do Cargo Regular'
            ]);
        }
        app('flasher')->addSuccess('Cargo Inserido com Sucesso!');
        return redirect()->route('IndexGerenciarCargoRegular');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $cargoregular = DB::table('cargo_regular')->where('id', $id)->first();

        $historicocargoregular = DB::table('hist_cargo_regular')
            ->where('id_cargoalterado', $id)->orderBy('id_hist', 'desc')
            ->get();

        return view('cargosregulares.hist-cargo-regular', compact('historicocargoregular', 'cargoregular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cargoregular = DB::table('cargo_regular')->where('id', $id)->first();


        return view('cargosregulares.editar-cargo-regular', compact('cargoregular'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $dataDeHoje = Carbon::today()->toDateString();

        if ($request->input('data_inicial') > $request->input('data_final') and $request->input('data_final') != null) {
            app('flasher')->addWarning("A data inicial é maior que a data final");
            return redirect()->route('IndexGerenciarCargoRegular');
        }

        if ($request->input('tipo_cargo') == 1) {
            DB::table('cargo_regular')->where('id', $id)->update([
                'nomeCR' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario'),
                'nomeCC' => null
            ]);
            DB::table('hist_cargo_regular')->insert([
                'id_cargoalterado' => $id,
                'dt_alteracao' => $dataDeHoje,
                'salarionovo' => $request->input('salario'),
                'motivoalt' => $request->input('motivoalteracao')
            ]);
        } elseif ($request->input('tipo_cargo') == 2) {
            // Insert different data for tipo_cargo == 2 if needed
            DB::table('cargo_regular')->where('id', $id)->update([
                'nomeCC' => $request->input('nomecargo'),
                'dt_inicioCR' => $request->input('data_inicial'),
                'dt_fimCR' => $request->input('data_final'),
                'salariobase' => $request->input('salario'),
                'nomeCR' => null

            ]);
            DB::table('hist_cargo_regular')->insert([
                'id_cargoalterado' => $id,
                'dt_alteracao' => $dataDeHoje,
                'salarionovo' => $request->input('salario'),
                'motivoalt' => $request->input('motivoalteracao')
            ]);
        }
        app('flasher')->addInfo('Alterado com sucesso');
        return redirect()->route('IndexGerenciarCargoRegular');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //DB::table('')
    }
}