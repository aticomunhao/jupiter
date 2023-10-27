<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GerenciarSetoresController extends Controller
{
    public function index(){
        $lista = DB:: select('select*from setores');

      //dd($lista);

       return view('/setores/gerenciar-setor');
    }
}
