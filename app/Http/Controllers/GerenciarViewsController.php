<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\ViewExterna;

class GerenciarViewsController extends Controller
{
    public function index()
    {
        
        // Usando o Model
        $dadosModel = ViewExterna::all();

        // Ou usando o Query Builder direto
        $dadosQuery = DB::connection('sqlsrv')->table('ati_v_contribuicoes')->get();

        $lista = DB::table('pessoal');

        return view('dados_externos.descontos', compact('dadosModel', 'dadosQuery'));
    }
}
