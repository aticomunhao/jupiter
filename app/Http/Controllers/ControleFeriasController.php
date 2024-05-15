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

class ControleFeriasController extends Controller
{
    public function index(Request $request)
    {

        $ferias = DB::table('ferias AS fe')
            ->leftJoin('status_pedido_ferias AS stf', 'fe.status_pedido_ferias', 'stf.id')
            ->leftJoin('funcionarios AS f', 'fe.id_funcionario', 'f.id')
            ->leftJoin('pessoas AS p', 'f.id_pessoa', 'p.id')
            ->select(
                'p.id AS id_pessoa',
                'fe.id AS id_ferias',
                'f.dt_inicio AS dt_inicio_funcionario',
                'fe.ano_referencia AS ano_referencia',
                'f.id AS id_funcionario',
                'stf.id AS id_stf',
                'stf.nome AS nome_stf',
                'f.id_setor AS id_setor',
                'fe.motivo_retorno AS motivo_retorno',
                'fe.dt_ini_a AS dt_ini_a',
                'fe.dt_fim_a AS dt_fim_b',
                'fe.dt_ini_b AS dt_ini_b',
                'fe.dt_fim_b AS dt_fim_b',
                'fe.dt_ini_c AS dt_ini_c',
                'fe.dt_fim_c AS dt_fim_c',
                )
                ->get();

        $referencia = DB::table('ferias AS fe')
        ->select('fe.ano_referencia AS ano_referencia')
        ->get();

        $pesquisa = $request->input('pesquisa');

        if ($pesquisa == 'cargo') {
            $cargoId = $request->input('cargo');
            $cargo->where('c.id', $cargoId);
            $vaga->where('va.id_cargo', $cargoId);
        }

        $cargo = $cargo->get();
        $vaga = $vaga->get();
        //dd($vaga, $cargo);


        $setor = DB::table('setor AS s')
            ->select('s.id AS idSetor', 's.nome AS nomeSetor')
            ->orderBy('nomeSetor');


        $pesquisa = $request->input('pesquisa');


        if ($pesquisa == 'setor') {
            $setorId = $request->input('setor');
            $setor->where('s.id', $setorId);
        }

        $setor = $setor->get();

        foreach ($setor as $key => $teste) {
            $vagaUm = DB::table('tp_vagas_autorizadas AS va')
                ->leftJoin('cargos AS c', 'c.id', 'va.id_cargo')
                ->select('va.vagas_autorizadas AS vagas', 'c.nome AS nomeCargo', 'c.id AS idCargo','va.id AS idVagas')
                ->where('va.id_setor', $teste->idSetor)
                ->get();

            $teste->bola = $vagaUm;

            foreach ($vagaUm as $keyDois => $testeDois) {
                $base = DB::table('base_salarial AS bs')
                    ->leftJoin('funcionarios AS f', 'bs.id_funcionario', 'f.id')
                    ->where('bs.cargo', $testeDois->idCargo)
                    ->where('f.id_setor', $teste->idSetor)
                    ->select(DB::raw('COUNT(bs.id_funcionario) AS quantidade'))
                    ->get();

                $testeDois->gato = $base;
            }
        }

        return view('ferias.controle-ferias', compact('cargo', 'setor', 'vaga', 'pesquisa'));
    }


/*
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
        }
        else {
            $data = [
                'id_cargo' => $cargoId,
                'id_setor' => $setorId,
                'vagas_autorizadas' => $request->input('number'),
            ];

            DB::table('tp_vagas_autorizadas')->insert($data);
            DB::table('hist_tp_vagas_autorizadas')->insert($data);
            app('flasher')->addSuccess('O cadastro das vagas foram realizadas com sucesso.');
            return redirect()->route('indexControleVagas');
        }
    }
    public function edit(string $idC)
    {
        // Recupere o cargo pelo ID
        $busca = DB::table('setor')
            ->leftJoin('tp_vagas_autorizadas AS va', 'setor.id', 'va.id_setor')
            ->leftJoin('cargos', 'cargos.id', 'va.id_cargo')
            ->where('id_cargo', $idC)
            ->select(
                'va.id_setor AS idSetor',
                'va.id_cargo AS idCargo',
                'va.vagas_autorizadas AS vTotal',
                'cargos.nome AS nomeCargo',
                'setor.nome AS nomeSetor',
                'va.id AS idVagas'
            )
            ->limit(1)
            ->get();
        //dd($busca);

        return view('efetivo.editar-vagas', compact('busca'));
    }


    public function update(Request $request, $idC)
    {
        // Obtenha o ID das vagas do formulário
        $idVagas = $request->input('idVagas');

        // Obtenha o número de vagas autorizadas enviado no formulário
        $numeroVagas = $request->input('number');

        // Atualize o número de vagas autorizadas na tabela tp_vagas_autorizadas
        DB::table('tp_vagas_autorizadas')
            ->where('id', $idVagas)
            ->update(['vagas_autorizadas' => $numeroVagas]);

            DB::table('hist_tp_vagas_autorizadas')
            ->where('id', $idVagas)
            ->update(['mudanca_vagas' => $numeroVagas, 'alteracao' => 'Mudanca na quantidade de Vagas']);

        // Redirecione de volta para a página de controle de vagas
        return redirect()->route('indexControleVagas');
    }

    public function destroy(string $idC)
{

    DB::table('tp_vagas_autorizadas')->where('id', $idC)->delete();
    DB::table('hist_tp_vagas_autorizadas')->where('id', $idC)->update(['alteracao' => 'Deletado']);

    return redirect()->route('indexControleVagas')->with('success', 'Vagas excluídas com sucesso!');
}*/

}
