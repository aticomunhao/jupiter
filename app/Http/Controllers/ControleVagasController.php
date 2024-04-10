<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\CollectionorderBy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class ControleVagasController extends Controller
{
    public function index(Request $request)
{
    $cargo = DB::table('cargos AS cr')
        ->leftJoin('base_salarial AS bs', 'bs.cargo', 'cr.id')
        ->leftJoin('funcionarios AS f', 'f.id', 'bs.id_funcionario')
        ->leftJoin('pessoas AS p', 'p.id', 'f.id_pessoa')
        ->leftJoin('setor AS s', 's.id', 'f.id_setor')
        ->leftJoin('tp_vagas_autorizadas AS va', 'va.id_setor', 's.id')
        ->leftJoin('tp_cargo', 'tp_cargo.idTpCargo', 'cr.tp_cargo')
        ->select('cr.id', 'cr.nome', 'bs.cargo', 'va.vagas_autorizadas', DB::raw('COUNT(bs.cargo) as total_funcionarios'))
        ->groupBy('cr.id', 'bs.cargo', 'va.vagas_autorizadas');


    $pesquisa = $request->input('pesquisa');

   if ($pesquisa === 'cargo') {
        $cargoId = $request->input('cargo');
        $cargo->where('cr.id', $cargoId);
    }

    $cargo = $cargo->get();

    $setor = DB::table('funcionarios AS f')
    ->leftJoin('setor AS s', 'f.id_setor', 's.id')
    ->leftJoin('base_salarial AS bs', 'f.id', 'bs.id_funcionario')
    ->leftJoin('cargos AS c', 'bs.cargo', 'c.id')
    ->leftJoin('tp_vagas_autorizadas AS va', 's.id', 'va.id_setor')
    ->leftJoin('tp_cargo', 'tp_cargo.idTpCargo', 'c.tp_cargo')
    ->select('s.nome AS nomeSetor', 's.id AS idSetor', 'c.cargo AS cargoFuncionario', DB::raw('COUNT(bs.cargo) as totalCargo'));


    if ($pesquisa === 'setor') {
        $setorId = $request->input('setor');
        $setor->where('s.id', $setorId);
    }

    $setor = $setor->get();



    return view('efetivo.controle-vagas', compact('cargo', 'setor', 'pesquisa'));
}



}
