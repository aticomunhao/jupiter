<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GerenciarEntidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entidades = DB::select('select * from tp_entidades_ensino');

        return view('entidadesensino.gerenciar-entidades-ensino', compact('entidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('entidadesensino.nova-entidade-ensino');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::table('tp_entidades_ensino')->insert([
            'nome' => $request->input('nome_ent')
        ]);


        return redirect()->route('batata');
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
        $entidade = DB::table('tp_entidades_ensino')->where('id',$id)->first();

        return view('entidadesensino.editar-entidade-ensino', compact('entidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::table('tp_entidades_ensino')
        ->where('id', $id)
        ->update([
            'nome' => $request->input('nome_ent')
        ]);
        return redirect()->route('batata');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tp_entidades_ensino')->where('id', $id)->delete();
        return redirect()->back();
    }
}
