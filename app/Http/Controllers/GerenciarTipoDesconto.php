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
