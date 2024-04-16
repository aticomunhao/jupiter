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
        /* $cargo = DB::table('cargos')
        ->leftJoin('tp_vagas_autorizadas AS va', 'va.id_cargo', 'cargos.id')
        ->leftJoin('setor AS s', 's.id', 'va.id_setor')
        ->leftJoin('funcionarios AS f', 'f.id_setor', 's.id')
        ->leftJoin('base_salarial AS bs', 'bs.cargo', 'cargos.id')
        ->select('cargos.id AS idCargo', 'cargos.nome AS nomeCargo', DB::raw('SUM(va.vagas_autorizadas) AS numero_funcionarios'), DB::raw('COUNT(bs.id_funcionario) AS numero_total'))
        ->groupBy('idCargo', 'nomeCargo');
        dd($cargo);
*/

        $cargo = DB::table('funcionarios AS f')
            ->leftJoin('setor AS s', 's.id', 'f.id_setor')
            ->leftJoin('tp_vagas_autorizadas AS va', 'va.id_setor', 's.id')
            ->leftJoin('cargos AS cr', 'cr.id', 'va.id_cargo')
            ->leftJoin('base_salarial AS bs', 'bs.id_funcionario', 'f.id')
            ->leftJoin('cargos AS c', 'bs.cargo', 'c.id')
            ->select('c.id AS idCargo', 'c.nome AS nomeCargo');

        $pesquisa = $request->input('pesquisa');

        if ($pesquisa == 'cargo') {
            $cargoId = $request->input('cargo');
            $cargo->whereNotNull('cargos.id', $cargoId);
        }

        $cargo = $cargo->get();
        //dd($cargo);




        $setor = DB::table('setor')
            ->select('setor.id AS idSetor', 'setor.nome AS nomeSetor');

        if ($pesquisa == 'setor') {
            $setorId = $request->input('setor');
            $setor->where('setor.id', $setorId);
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
