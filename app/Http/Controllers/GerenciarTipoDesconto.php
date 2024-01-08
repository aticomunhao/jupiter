<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GerenciarTipoDesconto extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desc = DB::select('select * from setor');

        return view('/tipopagamento/gerenciar-tp-desconto', compact('desc'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {



        return view('/tipopagamento/incluir-tp-desconto');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        app('flasher')->addSuccess("Entidade cadastrada com sucesso");
        return redirect()->route('indexTipoDesconto');
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
        $info = DB::table('setor')->where('id', $id)->first();

        return view('/tipopagamento/editar-tp-desconto', compact('info'));

    }

    /**
     * Update the specified resource in storage.
     */
    //Request $request, string $id
    public function update()
    {
        app('flasher')->addSuccess("Entidade cadastrada com sucesso");
        return redirect()->route('indexTipoDesconto');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
