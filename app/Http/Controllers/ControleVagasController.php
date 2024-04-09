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
        ->select('cr.id', 'cr.nome', 'bs.cargo', DB::raw('COUNT(bs.cargo) as total_funcionarios'))
        ->groupBy('cr.id', 'bs.cargo');

    $pesquisa = $request->input('pesquisa');

   if ($pesquisa === 'cargo') {
        $cargoId = $request->input('cargo');
        $cargo->where('cr.id', $cargoId);
    }

    $cargo = $cargo->get();

    $setor = DB::table('setor AS s')
        ->leftJoin('funcionarios AS f', 's.id', 'f.id_setor')
        ->leftJoin('base_salarial AS bs', 'f.id', 'bs.id_funcionario')
        ->leftJoin('pessoas AS p', 'p.id', 'f.id_pessoa')
        ->leftJoin('cargos AS c', 'bs.cargo', 'c.id')
        ->leftJoin('tp_vagas_autorizadas AS va', 'va.id_setor', 's.id')
        ->select('s.id', 's.nome','c.nome AS nomeCargo', DB::raw('COUNT(bs.cargo) as total_funcionarios'))
        ->groupBy('s.id', 's.nome', 'nomeCargo');

    if ($pesquisa === 'setor') {
        $setorId = $request->input('setor');
        $setor->where('s.id', $setorId);
    }

    $setor = $setor->get();



    return view('efetivo.controle-vagas', compact('cargo', 'setor', 'pesquisa'));
}



}
