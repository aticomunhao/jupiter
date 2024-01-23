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
        $pesquisa = request('pesquisa');

        if ($pesquisa) {
            $cargo = DB::table('cargos as c')
                ->leftJoin('tp_cargo as tp', 'tp.idTpCargo', '=', 'c.tp_cargo')
                ->select('c.id', 'c.nome', 'c.salario', 'c.dt_inicio', 'tp.nomeTpCargo', 'tp.idTpCargo','c.status') //faz uma pesquisa no banco apenas onde os valores batem
                ->where('c.nome', 'ilike', '%' . $pesquisa . '%')
                ->orWhere('tp.nomeTpCargo', 'ilike', '%' . $pesquisa . '%')
                ->orderBy('c.status', 'desc')
                ->get();
        } else {
            $cargo = DB::table('cargos as c')
                ->leftJoin('tp_cargo as tp', 'tp.idTpCargo', '=', 'c.tp_cargo')
                ->select('c.id', 'c.nome', 'c.salario', 'c.dt_inicio', 'tp.nomeTpCargo', 'tp.idTpCargo','c.status')
                ->orderBy('c.status', 'desc')
                ->get();
        }


        return view('cargos.gerenciar-cargos', compact('cargo', 'pesquisa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposCargo = DB::table('tp_cargo')->get();

        return view('cargos.incluir-cargos', compact('tiposCargo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $dataDeHoje = Carbon::today()->toDateString();

        $idCargo = DB::table('cargos')->insertGetId([
            'nome' => $input['nome'],
            'salario' => $input['salario'],
            'dt_inicio' => $dataDeHoje,
            'tp_cargo' => $input['tipoCargo'],
            'status' => true,
        ]);

        $cargo = DB::table('cargos')
            ->select('cargos.nome')
            ->where('id', $idCargo)
            ->first();

        DB::table('hist_cargo')->insert([
            'salario' => $input['salario'] ?? null,
            'data_inicio' => $dataDeHoje,
            'idcargo' => $idCargo,
            'motivoAlt' => 'Primeira Criação do Cargo',
        ]);
        app('flasher')->addSuccess("Cargo $cargo->nome adicionado com sucesso");
        return redirect()->route('gerenciar.cargos');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $cargo = DB::table('cargos')
            ->where('id', $id)
            ->select('id as idCR', 'nome as nomeCR')
            ->first();

        $hist_cargo_regular = DB::table('hist_cargo')
            ->select('id as idHist', 'salario as salarioHist', 'data_inicio', 'data_fim', 'motivoAlt')
            ->where('idcargo', '=', $id)
            ->orderBy('id', 'desc')
            ->get();


        return view('cargos\visualizar-cargos', compact('cargo', 'hist_cargo_regular'));
        //return redirect()->route('vizualizarHistoricoCargo')->with($cargoregular, $hist_cargo_regular);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cargo = DB::table('cargos as c')
            ->where('c.id', $id)
            ->first();

        $tiposCargo = DB::table('tp_cargo')->get();
        $id = $id;

        return view('/cargos/editar-cargos', compact('cargo', 'tiposCargo', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cargo = DB::table('cargos as c')
            ->where('c.id', $id)
            ->first();


        $input = $request->all();
        $dataDeHoje = Carbon::today()->toDateString();
        $dataDeOntem = Carbon::yesterday()->toDateString();


        $ultimaModificacao = DB::table('hist_cargo')
            ->where('idcargo', '=', $id)
            ->where('data_fim', null)->first();

        DB::table('hist_cargo')
            ->where('id', $ultimaModificacao->id)
            ->update([
                'data_fim' => $dataDeOntem,
            ]);

        DB::table('cargos')
            ->where('id', $id)
            ->update([
                'nome' => $input['nome'],
                'salario' => $input['salario'],
                'dt_inicio' => $dataDeHoje,
                'tp_cargo' => $input['tipocargo']
            ]);

        DB::table('hist_cargo')->insert([
            'salario' => $input['salario'],
            'data_inicio' => $dataDeHoje,
            'idcargo' => $id,
            'motivoAlt' => $input['motivo']
        ]);

        $cargo = DB::table('cargos as c')
            ->where('c.id', $id)
            ->first();
        app('flasher')->addUpdated("$cargo->nome");
        return redirect()->route('gerenciar.cargos');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $dataDeHoje = Carbon::today()->toDateString();
         $ultimaModificacao = DB::table('hist_cargo')
            ->where('idcargo', '=', $id)
            ->where('data_fim', null)->first();


        DB::table('hist_cargo')
            ->where('id', $ultimaModificacao->id)
            ->update([
                'data_fim'=> $dataDeHoje
            ]);

        DB::table('hist_cargo')
            ->insert([
                'salario' => $ultimaModificacao->salario,
                'data_inicio' => $dataDeHoje,
                'idcargo' => $ultimaModificacao->idcargo,
                'motivoAlt' => 'Fim do Cargo'
            ]);


        $cargofechado = DB::table('cargos')->where('id', $ultimaModificacao->idcargo)->first();
        DB::table('cargos')
            ->where('id', $ultimaModificacao->idcargo)
            ->update([
                'dt_inicio' => $dataDeHoje,
                'status' =>false
                ]);

        app('flasher')->addDeleted("$cargofechado->nome");
        return  redirect()->route('gerenciar.cargos');

    }
}
