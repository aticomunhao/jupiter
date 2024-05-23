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
            ->leftJoin('setor AS s', 'f.id_setor', 's.id')
            ->leftJoin('base_salarial AS bs', 'f.id', 'bs.id_funcionario')
            ->leftJoin('cargos AS c', 'bs.cargo', 'c.id')
            ->select(
                'p.id AS id_pessoa',
                'fe.id AS id_ferias',
                'f.dt_inicio AS dt_inicio_funcionario',
                'fe.ano_de_referencia AS ano_de_referencia',
                'f.id AS id_funcionario',
                'stf.id AS id_stf',
                'f.id_setor AS id_setor',
                'p.nome_completo AS nome_completo',
                'fe.inicio_periodo_aquisitivo AS ini_aqt',
                'fe.fim_periodo_aquisitivo AS fim_aqt',
                'stf.nome AS nome_stf',
                's.nome AS nome_setor',
                'c.nome AS nome_cargo',
                's.sigla AS sigla_setor',
                'fe.dt_ini_a AS dt_ini_a',
                'fe.dt_fim_a AS dt_fim_a',
                'fe.dt_ini_b AS dt_ini_b',
                'fe.dt_fim_b AS dt_fim_b',
                'fe.dt_ini_c AS dt_ini_c',
                'fe.dt_fim_c AS dt_fim_c',
                'fe.vendeu_ferias AS vendeu_ferias',
                'fe.dt_inicio_periodo_de_licenca AS dt_inicio_gozo',
                'fe.dt_fim_periodo_de_licenca AS dt_fim_gozo',
            )
            ->orderBy('nome_completo')
            ->paginate(19);


        return view('ferias.controle-ferias', compact('ferias'));
    }
}
