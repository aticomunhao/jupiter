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
            ->leftJoin('tp_vagas_autorizadas AS va', 'va.id_cargo', 'cr.id')
            ->leftJoin('setor AS s', 's.id', 'va.id_setor')
            ->leftJoin('funcionarios AS fu', 'fu.id_setor', 's.id')
            ->select('cr.id AS idCargo', 'cr.nome AS nomeCargo', 'va.vagas_autorizadas AS vagasTotais', DB::raw('COUNT(bs.cargo) AS numero_funcionario'))
            ->groupBy('idCargo', 'nomeCargo', 'vagasTotais');

        $pesquisa = $request->input('pesquisa');

        if ($pesquisa === 'cargo') {
            $cargoId = $request->input('cargo');
            $cargo->whereNotNull('cr.id', $cargoId);
        }

        $cargo = $cargo->get();

        $setor = DB::table('setor AS s')
            ->leftJoin('tp_vagas_autorizadas AS va', 'va.id_setor', 's.id')
            ->leftJoin('funcionarios AS f', 'f.id_setor', 's.id')
            ->leftJoin('base_salarial AS bs', 'bs.id_funcionario', 'f.id')
            ->leftJoin('cargos AS c', 'c.id', 'bs.cargo')
            ->select('s.id AS idSetor', 's.nome AS nomeSetor', 'va.vagas_autorizadas AS vagasTotais', 'c.nome AS nomeCargo', DB::raw('COUNT(bs.cargo) AS numero_funcionario'))
            ->groupBy('idSetor', 'nomeSetor', 'nomeCargo', 'vagasTotais');

        if ($pesquisa === 'setor') {
            $setorId = $request->input('setor');
            $setor->whereNotNull('s.id', $setorId);
        }

        $setor = $setor->get();

        return view('efetivo.controle-vagas', compact('cargo', 'setor', 'pesquisa'));
    }



    public function create()
    {
        $cargo = DB::table('cargos')
            ->select('cargos.id AS idCargo', 'cargos.nome AS nomeCargo')
            ->get();

        $setor = DB::table('setor')
            ->select('setor.id AS idSetor', 'setor.nome AS nomeSetor')
            ->get();


        return view('efetivo.incluir-vagas', compact('cargo', 'setor'));
    }




    public function store(Request $request)
    {
        $cargoId = $request->input('vagasCargo');
        $setorId = $request->input('vagasSetor');

        // Verificar se já existem vagas para o cargo no setor
        $existingVagas = DB::table('tp_vagas_autorizadas')
            ->where('id_cargo', $cargoId)
            ->where('id_setor', $setorId)
            ->exists();

        if ($existingVagas) {
            app('flasher')->addError('Esse Cargo já possui vagas nesse Setor.');
            return redirect()->route('indexControleVagas');
        } else {
            $data = [
                'id_cargo' => $cargoId,
                'id_setor' => $setorId,
                'vagas_autorizadas' => $request->input('number'),
            ];

            DB::table('tp_vagas_autorizadas')->insert($data);
            app('flasher')->addSuccess('O cadastro das vagas foram realizadas com sucesso.');
            return redirect()->route('indexControleVagas');
        }
    }
}
