<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class GerenciarFuncionarioController extends Controller
{

    public function index(){

        $result=DB::select('select cpf, rg, nome_pessoa, sexo from pessoa');

        //dd($result);

       return view('\funcionarios.gerenciar-funcionario', compact ('result'));

    }



}
