<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\CollectionorderBy;
use Carbon\Carbon;


class GerenciarAreasController extends Controller
{ 
    public function index(Request $request)
    {  
     


        return view('/setores/adicionar-areas');
    }
}