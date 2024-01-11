<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class GerenciarVoluntarioController extends Controller
{
<<<<<<< Updated upstream
    public function index(Request $request)
    {
=======

    public function index(Request $request){

       
        return view('voluntario.gerenciar-voluntario');
    

>>>>>>> Stashed changes
    }

    public function store()
    {
    }

    public function insert(Request $request)
    {
    }
}
