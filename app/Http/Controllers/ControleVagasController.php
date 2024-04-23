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
use PhpParser\Node\Expr\AssignOp\ShiftLeft;

class ControleVagasController extends Controller
{
    public function index(Request $request)
    {

        $cargo = DB::table('cargos AS c')
            ->leftJoin('base_salarial AS bs', 'bs.cargo', 'c.id')
            ->select(DB::raw('COUNT(bs.id_funcionario) AS quantidade_funcionarios'), 'c.id AS idCargo', 'c.nome AS nomeCargo')
            ->groupBy('idCargo', 'nomeCargo');


        $vaga = DB::table('tp_vagas_autorizadas AS va')
            ->leftJoin('cargos AS cr', 'cr.id', 'va.id_cargo')
            ->select(DB::raw('SUM(va.vagas_autorizadas) AS total_vagas'), 'cr.id AS idDoCargo')
            ->groupBy('idDoCargo');


        $pesquisa = $request->input('pesquisa');

        if ($pesquisa == 'cargo') {
            $cargoId = $request->input('cargo');
            $cargo->where('c.id', $cargoId);
            $vaga->where('cr.id', $cargoId);
        }
        
        $cargo = $cargo->get();
        $vaga = $vaga->get();


        $setor = DB::table('tp_vagas_autorizadas AS va')
            ->leftJoin('setor AS s', 's.id', 'va.id_setor')
            ->leftJoin('cargos AS cr', 'cr.id', 'va.id_cargo')
            ->select(DB::raw('SUM(va.vagas_autorizadas) AS total_vagas'), 'cr.id AS idDoCargo', 's.id AS idSetor', 'cr.nome AS nomeCargo', 's.nome AS nomeSetor')
            ->groupBy('idDoCargo', 'idSetor', 'nomeCargo', 'nomeSetor');


        if ($pesquisa == 'setor') {
            $setorId = $request->input('setor');
            $setor->where('s.id', $setorId);
            $cargo->where('c.id', $setorId);
            $vaga->where('cr.id', $setorId);
        }

        $setor = $setor->get();

        //dd($setor, $cargo, $vaga);


        return view('efetivo.controle-vagas', compact('cargo', 'setor', 'pesquisa', 'vaga'));
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
