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

use function Laravel\Prompts\select;

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
                'p.nome_resumido AS nome_resumido',
                'fe.inicio_periodo_aquisitivo AS ini_aqt',
                'fe.fim_periodo_aquisitivo AS fim_aqt',
                'stf.nome AS nome_stf',
                's.nome AS nome_setor',
                'c.nome AS nome_cargo',
                's.sigla AS sigla_setor',
                's.id AS idSetor',
                'fe.dt_ini_a AS dt_ini_a',
                'fe.dt_fim_a AS dt_fim_a',
                'fe.dt_ini_b AS dt_ini_b',
                'fe.dt_fim_b AS dt_fim_b',
                'fe.dt_ini_c AS dt_ini_c',
                'fe.dt_fim_c AS dt_fim_c',
                'fe.vendeu_ferias AS vendeu_ferias',
                'fe.dt_inicio_periodo_de_licenca AS dt_inicio_gozo',
                'fe.dt_fim_periodo_de_licenca AS dt_fim_gozo',
            );
        $setor_selecionado = null;
        $mes_selecionado = null;
        $ano_selecionado = null;
        $mes_gozo_ferias = null;
        $setor_selecionado = $request->setor;
        $mes_selecionado = $request->mes_gozo_ferias;
        $ano_selecionado = $request->ano;
        $mes_gozo_ferias = $request->input('mes_gozo_ferias');
        $mes = [
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Março",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro"
        ];
        if ($request->setor) {
            $ferias->where('s.id', $setor_selecionado);
            $setor_selecionado = DB::table('setor')
                ->where('id', '=', $setor_selecionado)
                ->first();
        }
        // if ($request->input('mes_gozo_ferias')) {
        //     $ferias->whereMonth('fim_aqt', '=', $mes_gozo_ferias);

        // }
        if ($request->mes_gozo_ferias) {
            $ferias->whereMonth('fe.dt_inicio_periodo_de_licenca', $mes_selecionado);
            $mes_selecionado = [
                'indice' => $request->input('mes_gozo_ferias'),
                'nome' => $mes[$request->input('mes_gozo_ferias')]
            ];
        }
        if ($request->ano) {
            $ferias->where('fe.ano_de_referencia', $ano_selecionado);
            $ano_selecionado = $request->input('ano');
        }


        $ferias = $ferias->orderBy('nome_completo')->paginate(50);

        $ano = DB::table('ferias AS fe')
            ->select('fe.ano_de_referencia AS ano_de_referencia')
            ->orderBy('ano_de_referencia')
            ->distinct()
            ->get();

        $setor = DB::table('setor AS s')
            ->select(
                's.nome AS nome_setor',
                's.id AS idSetor',
                's.sigla AS siglaSetor',
            )
            ->orderBy('nome_setor',)
            ->distinct()
            ->get();
        //dd($setor);
        //dd($ano);
        // dd($mes_selecionado);
        //  dd($setor_selecionado != null);
        return view('ferias.controle-ferias', compact('ferias', 'mes', 'ano', 'setor', 'setor_selecionado', 'mes_gozo_ferias', 'mes_selecionado', 'ano_selecionado'));
    }

}
