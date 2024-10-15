<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GerenciarFeriasController extends Controller
{
    // Adicione isso no topo do seu arquivo se ainda não estiver incluído

    public function index(Request $request)
    {
        // Recupera os registros de férias com as devidas junções
        $periodo_aquisitivo = DB::table('ferias')
            ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
            ->select(
                'pessoas.nome_completo as nome_completo_funcionario',
                'pessoas.id as id_pessoa',
                'ferias.dt_ini_a',
                'ferias.dt_fim_a',
                'ferias.dt_ini_b',
                'ferias.dt_fim_b',
                'ferias.dt_ini_c',
                'ferias.dt_fim_c',
                'ferias.motivo_retorno',
                'ferias.id as id_ferias',
                'ferias.venda_um_terco',
                'funcionarios.dt_inicio',
                'ferias.ano_de_referencia',
                'ferias.id_funcionario',
                'status_pedido_ferias.id as id_status_pedido_ferias',
                'status_pedido_ferias.nome as status_pedido_ferias',
                'funcionarios.id_setor',

            )
            ->whereIn('funcionarios.id_setor', session('usuario.setor'));
        $ano_consulta = null;
        $nome_funcionario = null;
        $status_consulta_atual = null;

        // Filtros
        if ($request->input('anoconsulta')) {
            $ano_referente = $request->input('anoconsulta');
            $periodo_aquisitivo->where('ferias.ano_de_referencia', $ano_referente);
            $ano_consulta = $ano_referente;
        }
        if ($request->input('nomefuncionario')) {
            $nome_funcionario = $request->input('nomefuncionario');
            $periodo_aquisitivo->where('pessoas.nome_completo', 'ilike', '%' . $nome_funcionario . '%');
            $nome_funcionario = $nome_funcionario;
        }
        if ($request->input('statusconsulta')) {
            $status_consulta = $request->input('statusconsulta');
            $periodo_aquisitivo->where('status_pedido_ferias.id', $status_consulta);
            $status_consulta_atual = DB::table('status_pedido_ferias')->where('id', $status_consulta)->first();
        }

        $periodo_aquisitivo = $periodo_aquisitivo->get();

        // Verifica conflitos de períodos
        foreach ($periodo_aquisitivo as $p1) {
            $p1->em_conflito = false;
            foreach ($periodo_aquisitivo as $p2) {
                // Verifique se as datas de $p2 não são nulas e se $p1 tem datas válidas
                if ($p1->id_ferias != $p2->id_ferias && $this->hasValidDates($p1) && $this->hasValidDates($p2)) {
                    // Verifique conflitos para todos os períodos de $p1
                    if ($this->hasDateConflict($p1, $p2)) {
                        $p1->em_conflito = true;
                        break; // Se já encontrou um conflito, não precisa verificar mais
                    }
                }
            }
        }

        // Recupera anos e status possíveis
        $anos_possiveis = DB::table('ferias')->select('ano_de_referencia')->groupBy('ano_de_referencia')->get();
        $status_ferias = DB::table('status_pedido_ferias')->get();


        return view('ferias.gerenciar-ferias', compact('periodo_aquisitivo', 'anos_possiveis', 'status_ferias', 'ano_consulta', 'nome_funcionario', 'status_consulta_atual'));
    }

    private function hasDateConflict($p1, $p2)
    {
        // Verificar conflito entre todos os períodos possíveis de $p1 e $p2
        return ($this->isPeriodInConflict($p1->dt_ini_a, $p1->dt_fim_a, $p2->dt_ini_a, $p2->dt_fim_a, $p2->dt_ini_b, $p2->dt_fim_b, $p2->dt_ini_c, $p2->dt_fim_c) ||
            $this->isPeriodInConflict($p1->dt_ini_b, $p1->dt_fim_b, $p2->dt_ini_a, $p2->dt_fim_a, $p2->dt_ini_b, $p2->dt_fim_b, $p2->dt_ini_c, $p2->dt_fim_c) ||
            $this->isPeriodInConflict($p1->dt_ini_c, $p1->dt_fim_c, $p2->dt_ini_a, $p2->dt_fim_a, $p2->dt_ini_b, $p2->dt_fim_b, $p2->dt_ini_c, $p2->dt_fim_c));
    }


    private function hasValidDates($periodo)
    {
        return !is_null($periodo->dt_ini_a) && !is_null($periodo->dt_fim_a) ||
            !is_null($periodo->dt_ini_b) && !is_null($periodo->dt_fim_b) ||
            !is_null($periodo->dt_ini_c) && !is_null($periodo->dt_fim_c);
    }

    function isPeriodInConflict($periodStart, $periodEnd, $start1, $end1, $start2, $end2, $start3, $end3)
    {
        // Verifica se algum dos períodos é nulo e, se for, ignora a verificação para esse período
        if (is_null($start1) || is_null($end1)) $start1 = $end1 = null;
        if (is_null($start2) || is_null($end2)) $start2 = $end2 = null;
        if (is_null($start3) || is_null($end3)) $start3 = $end3 = null;

        // Se o período em questão é nulo, não pode haver conflito
        if (is_null($periodStart) || is_null($periodEnd)) {
            return false;
        }

        // Se o período é menor do que qualquer um dos intervalos válidos, não há conflito
        if (($start1 && $periodEnd < $start1) || ($start2 && $periodEnd < $start2) || ($start3 && $periodEnd < $start3)) {
            return false;
        }

        // Se o período começa depois do fim de qualquer intervalo válido, não há conflito
        if (($end1 && $periodStart > $end1) || ($end2 && $periodStart > $end2) || ($end3 && $periodStart > $end3)) {
            return false;
        }

        // Verifica conflito com os intervalos válidos
        $conflict = false;
        if ($start1 && $end1) {
            $conflict = $periodStart <= $end1 && $periodEnd >= $start1;
        }
        if ($start2 && $end2) {
            $conflict = $conflict || ($periodStart <= $end2 && $periodEnd >= $start2);
        }
        if ($start3 && $end3) {
            $conflict = $conflict || ($periodStart <= $end3 && $periodEnd >= $start3);
        }

        return $conflict;
    }

    /**
     * Show the form for creating a new resource.
     */
    public
    function create($id_ferias)
    {
        try {
            $ano_referente = Carbon::now()->year - 1;
            $periodo_aquisitivo = DB::table('ferias')
                ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
                ->select(
                    'pessoas.nome_completo as nome_completo_funcionario',
                    'pessoas.id as id_pessoa',
                    'ferias.dt_ini_a',
                    'ferias.dt_fim_a',
                    'ferias.dt_ini_b',
                    'ferias.dt_fim_b',
                    'ferias.dt_ini_c',
                    'ferias.dt_fim_c',
                    'ferias.id as id_ferias',
                    'ferias.motivo_retorno',
                    'funcionarios.dt_inicio',
                    'ferias.ano_de_referencia',
                    'ferias.id_funcionario',
                    'status_pedido_ferias.id as id_status_pedido_ferias',
                    'status_pedido_ferias.nome as status_pedido_ferias',
                    'ferias.dt_fim_periodo_de_licenca',
                    'ferias.dt_inicio_periodo_de_licenca',
                    'ferias.inicio_periodo_aquisitivo',
                    'ferias.fim_periodo_aquisitivo'
                )
                ->where('ferias.id', $id_ferias)
                ->first();

            return view('ferias.incluir-ferias', compact('ano_referente', "periodo_aquisitivo", 'id_ferias'));
        } catch (Exception $e) {
            DB::rollBack();
            app('flasher')->addError("Houve um erro inesperado: #" . $e->getCode());
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public
    function store(Request $request, $id)
    {
    }

    /**
     * Display the specified resource.
     */
    /*Historico de Devoluções*/
    public
    function show(string $id)
    {
        try {
            $ano_referencia = Carbon::now()->year - 1;

            $periodo_de_ferias = DB::table('ferias')->where('id', '=', $id)->first();


            $funcionario = DB::table('funcionarios')
                ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')->where('funcionarios.id', '=', $periodo_de_ferias->id_funcionario)->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'pessoas.nome_completo', 'funcionarios.dt_inicio')->first();


            $historico_recusa_ferias = DB::table('hist_recusa_ferias')->where('id_periodo_de_ferias', '=', $id)->get();

            if (empty($historico_recusa_ferias)) {
                app('flasher')->addInfo("Não há nenhuma informação das férias do funcionário:  $funcionario->nome_completo.");
                return redirect()->back();
            }
            //
            // dd($periodo_de_ferias);


            return view('ferias.historico-ferias', compact('periodo_de_ferias', 'historico_recusa_ferias', 'funcionario'));
        } catch (Exception $exception) {
            DB::rollBack();
            app('flasher')->addError($exception->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(string $id)
    {
    }

    public
    function InsereERetornaFuncionarios(Request $request)
    {

        $ano_referencia = $request->input('ano_referencia');

        if (empty($ano_referencia)) {
            $ano_referencia = Carbon::now()->year - 1;
        } else {
            $ano_referencia = $request->input('ano_referencia');
        }


        $dia_do_ultimo_ano = Carbon::createFromDate($ano_referencia, 12, 31)->toDateString();

        $funcionarios = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->join('acordo', 'funcionarios.id', '=', 'acordo.id_funcionario')
            ->where('acordo.dt_inicio', '<', $dia_do_ultimo_ano)
            ->where('acordo.dt_fim', '=', null)
            ->where('acordo.tp_acordo', '=', 1)
            ->select('pessoas.id as id_pessoa',
                'funcionarios.id as id_funcionario',
                'acordo.dt_inicio as data_de_inicio',
                'pessoas.nome_completo')
            ->get();


        //Codigo para olhar para o funcionario
        foreach ($funcionarios as $funcionario) {
            $periodo_de_ferias_do_funcionario = DB::table('ferias')
                ->where('id_funcionario', '=', $funcionario->id_funcionario)
                ->where('ano_de_referencia', '=', $ano_referencia)
                ->first();
            $dias_afastado = 0;// Variavel que armazena a quantidade de dias que o funcionario ficou afastado por conta da COVID ou demais casos
            if (empty($periodo_de_ferias_do_funcionario)) {
                //$dias_limite_de_gozo = DB::table('hist_dia_limite_de_ferias')->where('data_fim', '=', null)->first();
                $data_inicio = Carbon::parse($funcionario->data_de_inicio);
                $afastamentos = DB::table('afastamento')
                    ->where('id_funcionario', '=', $funcionario->id_funcionario);

                if ($afastamentos->count() > 0) {
                    foreach ($afastamentos as $afastamento) {
                        $dias_de_afastamento = Carbon::parse($afastamento->dt_inicio)->diffInDays($afastamento->dt_fim);
                        $dias_afastado += $dias_de_afastamento;

                    }
                    $data_inicio = $data_inicio->addDays($dias_afastado);

                }


                $data_inicio_periodo_aquisitivo = $data_inicio->copy()->subYear()->year($ano_referencia)->toDateString();
                $data_fim_periodo_aquisitivo = $data_inicio->copy()->subYear()->year($ano_referencia + 1)->subDay()->toDateString();
                $funcionario->data_inicio_periodo_aquisitivo = $data_inicio_periodo_aquisitivo;
                $funcionario->data_fim_periodo_aquisitivo = $data_fim_periodo_aquisitivo;
                $funcionario->data_inicio_periodo_de_gozo = $data_inicio->copy()->addYear()->year($ano_referencia + 1)->toDateString();
                $funcionario->data_fim_periodo_de_gozo = $data_inicio->copy()->addYear()->year($ano_referencia + 2)->subDay()->toDateString();
                $id_ferias = DB::table('ferias')->insertGetId(['ano_de_referencia' => $ano_referencia, 'inicio_periodo_aquisitivo' => $funcionario->data_inicio_periodo_aquisitivo, 'fim_periodo_aquisitivo' => $funcionario->data_fim_periodo_aquisitivo, 'status_pedido_ferias' => 1, 'id_funcionario' => $funcionario->id_funcionario, 'dt_inicio_periodo_de_licenca' => $funcionario->data_inicio_periodo_de_gozo, 'dt_fim_periodo_de_licenca' => $funcionario->data_fim_periodo_de_gozo]);
                DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $id_ferias, 'motivo_retorno' => "Criação do Formulario de Férias", 'data_de_acontecimento' => Carbon::now()->toDateString()]);
            }
        }

        /*
        foreach ($contratos as $contrato) {
            $periodo_de_ferias_do_funcionario = DB::table('ferias')->where('id_funcionario', '=', $contrato->id_funcionario)->where('ano_de_referencia', '=', $ano_referencia)->first();
            if (empty($periodo_de_ferias_do_funcionario)) {
                $data_inicio = Carbon::parse($contrato->data_de_inicio);
                $data_inicio_periodo_aquisitivo = $data_inicio->copy()->subYear()->year($ano_referencia)->toDateString();
                $data_fim_periodo_aquisitivo = $data_inicio->copy()->subYear()->year($ano_referencia + 1)->subDay()->toDateString();
                $funcionario->data_inicio_periodo_aquisitivo = $data_inicio_periodo_aquisitivo;
                $funcionario->data_fim_periodo_aquisitivo = $data_fim_periodo_aquisitivo;
                $funcionario->data_inicio_periodo_de_gozo = $data_inicio->copy()->addYear()->year($ano_referencia + 1)->toDateString();
                $funcionario->data_fim_periodo_de_gozo = $data_inicio->copy()->addYear()->year($ano_referencia + 2)->subDay()->toDateString();
                $id_ferias = DB::table('ferias')->insertGetId(['ano_de_referencia' => $ano_referencia, 'inicio_periodo_aquisitivo' => $funcionario->data_inicio_periodo_aquisitivo, 'fim_periodo_aquisitivo' => $funcionario->data_fim_periodo_aquisitivo, 'status_pedido_ferias' => 1, 'id_funcionario' => $funcionario->id_funcionario, 'dt_inicio_periodo_de_licenca' => $funcionario->data_inicio_periodo_de_gozo, 'dt_fim_periodo_de_licenca' => $funcionario->data_fim_periodo_de_gozo]);
                DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $id_ferias, 'motivo_retorno' => "Criação do Formulario de Férias", 'data_de_acontecimento' => Carbon::now()->toDateString()]);
            }
        }
        */

        app('flasher')->addSuccess("Periodo Aquisitivo dos anos " . $ano_referencia . " - " . $ano_referencia + 1 . "foi criado");
        return redirect()->route('AdministrarFerias');
    }

    public
    function administraferias(Request $request)
    {

        try {
            if (!empty($request->input('search'))) {
                $ano_referente = $request->input('search');
            } else {
                $ano_referente = DB::table('ferias')->max('ano_de_referencia');
            }


            $periodo_aquisitivo = DB::table('ferias')
                ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
                ->join('setor as s', 's.id', '=', 'id_setor')
                ->select(
                    'pessoas.nome_completo as nome_completo_funcionario',
                    'pessoas.id as id_pessoa',
                    'ferias.dt_ini_a',
                    'ferias.dt_fim_a',
                    'ferias.dt_ini_b',
                    'ferias.dt_fim_b',
                    'ferias.dt_ini_c',
                    'ferias.dt_fim_c',
                    'ferias.motivo_retorno',
                    'ferias.id as id_ferias',
                    'ferias.venda_um_terco',
                    'funcionarios.dt_inicio',
                    'ferias.ano_de_referencia',
                    'ferias.id_funcionario',
                    'ferias.adianta_13sal',
                    'status_pedido_ferias.id as id_status_pedido_ferias',
                    'status_pedido_ferias.nome as status_pedido_ferias',
                    's.sigla as sigla_do_setor',
                    's.id as id_do_setor'
                )
                ->orderBy('nome_completo_funcionario');
            $ano_consulta = null;
            $nome_funcionario = null;
            $status_consulta = null;
            $setor = null;

            $anos_possiveis = DB::table('ferias')->select('ano_de_referencia')->groupBy('ano_de_referencia')->get();
            $status_ferias = DB::table('status_pedido_ferias');
            $status_consulta_atual = null; // Inicialize a variável com valor padrão

            if ($request->input('anoconsulta')) {
                $ano_referente = $request->input('anoconsulta');
                $periodo_aquisitivo = $periodo_aquisitivo->where('ferias.ano_de_referencia', '=', $ano_referente);
                $ano_consulta = $request->input('anoconsulta');
            }
            if ($request->input('nomefuncionario')) {
                $nome_funcionario = $request->input('nomefuncionario');
                $periodo_aquisitivo = $periodo_aquisitivo->where('pessoas.nome_completo', 'ilike', '%' . $nome_funcionario . '%');
                $nome_funcionario = $request->input('nomefuncionario');
            }
            if ($request->input('statusconsulta')) {
                $status_consulta = $request->input('statusconsulta');
                $periodo_aquisitivo = $periodo_aquisitivo->where('status_pedido_ferias.id', '=', $status_consulta);
                $status_consulta = DB::table('status_pedido_ferias')->where('id', '=', $status_consulta)->first();
            }
            if ($request->input('setorconsulta')) {
                $setor = $request->input('setorconsulta');
                $periodo_aquisitivo = $periodo_aquisitivo->where('s.id', '=', $setor);
                $setor = DB::table('setor')->where('id', '=', $setor)->first();

            }

            $nome_funcionario = $request->input('nomefuncionario');


            // $setores_unicos = $periodo_aquisitivo->map(function ($item) {
            //   return (object)[
            //     'id_do_setor' => $item->id_do_setor,
            //    'sigla_do_setor' => $item->sigla_do_setor,
            //    ]//;
            // })->unique('id_do_setor')->values();
            $setores_unicos = DB::table('setor')->get();
            $anos_possiveis = DB::table('ferias')->select('ano_de_referencia')->groupBy('ano_de_referencia')->get();
            $anos_inicial = DB::table('ferias')->select('ano_de_referencia')->groupBy('ano_de_referencia')->first();
            $anos_final = DB::table('ferias')->select('ano_de_referencia')->groupBy('ano_de_referencia')->orderBy('ano_de_referencia', 'desc')->first();
            $status_ferias = DB::table('status_pedido_ferias')->get();
            if (!empty($anos_inicial)) {
                $anoAnterior = intval($anos_inicial->ano_de_referencia) - 2;
                $doisAnosFrente = intval($anos_final->ano_de_referencia) + 5;
            } else {
                $anoAnterior = intval(Carbon::now()->subYear(2)->toDateString());
                $doisAnosFrente = intval(Carbon::now()->addYear(5)->toDateString());
            };

            $listaAnos = range($anoAnterior, $doisAnosFrente);
            $periodo_aquisitivo = $periodo_aquisitivo->get();


            return view('ferias.administrar-ferias', compact('periodo_aquisitivo',
                'anos_possiveis',
                'listaAnos',
                'ano_consulta',
                'setores_unicos',
                'status_ferias',
                'nome_funcionario',
                'ano_referente',
                'setor',
                'periodo_aquisitivo',
                'status_consulta'));
        } catch (Exception $exception) {
            DB::rollBack();
            app('flasher')->addError($exception->getMessage());
            return redirect()->back();
        }
    }

    public
    function autorizarferias($id)
    {
        try {
            $periodo_de_ferias = DB::table('ferias')->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')->select(
                'pessoas.nome_completo as nome_completo_funcionario',
            )->where('ferias.id', '=', $id)->first();
            DB::table('ferias')->where('id', '=', $id)->update(['status_pedido_ferias' => 6]);
            DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $id, 'motivo_retorno' => "Férias e Autoridas e Homologadas.", 'data_de_acontecimento' => Carbon::today()->toDateString()]);
            app('flasher')->addSuccess("As ferias do funcionario $periodo_de_ferias->nome_completo_funcionario foram autorizadas.");
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            app('flasher')->addError($exception->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(Request $request, string $id)
    {


        // Obtém os dados do formulário de férias
        $formulario_de_ferias = $request->all();


        $adiantar_decimo_terceiro = false;
        $ferias = DB::table('ferias')->where('id', $id)->first();

        $dias_limite_de_ferias = DB::table('hist_dia_limite_de_ferias')->where('data_fim', '=', null)->first();
        $dia_limite_para_inicio_do_periodo_de_ferias = Carbon::parse($ferias->dt_fim_periodo_de_licenca)->subDays((365 - $dias_limite_de_ferias->dias))->toDateString();


        // Obtém o ano de referência
        $ano_referente = $ferias->ano_de_referencia;

        // Obtém informações do funcionário
        $funcionario = DB::table('funcionarios')->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'pessoas.nome_completo', 'funcionarios.dt_inicio')->first();
        //

        // Obtém informações sobre as férias do funcionário


        // Calcula os dias de direito do funcionário (exemplo: 30 dias de férias - dias de falta)
        $faltas = 0;

        $atestados = DB::table('afastamento')->join('tp_afastamento', 'afastamento.id_tp_afastamento', '=', 'tp_afastamento.id')->where('dt_inicio', '>=', $ferias->inicio_periodo_aquisitivo)->where('dt_fim', '<=', $ferias->fim_periodo_aquisitivo)->select('tp_afastamento.limite', 'afastamento.qtd_dias')->get();

        foreach ($atestados as $atestado) {
            $faltas += $atestado->qtd_dias - $atestado->limite;
        }

        if ($faltas <= 5) {
            $diasDeDireitoDoFuncionario = 30;
        } elseif ($faltas >= 6 && $faltas <= 14) {
            $diasDeDireitoDoFuncionario = 24;
        } elseif ($faltas >= 15 && $faltas <= 23) {
            $diasDeDireitoDoFuncionario = 18;
        } elseif ($faltas >= 24 && $faltas <= 32) {
            $diasDeDireitoDoFuncionario = 12;
        } else {
            $diasDeDireitoDoFuncionario = 0;

            DB::table('ferias')->where('id', '=', $ferias->id)->update(['status_pedido_ferias' => 6, 'motivo_retorno' => "O funcionario não possui direito a  por ter faltado mais de 32 dias sem abono"]);
            DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $id, 'motivo_retorno' => "O funcionario não possui direito a  por ter faltado mais de 32 dias sem abono", 'data_de_acontecimento' => Carbon::today()->toDateString()]);
            app('flasher')->addError('O funcionario não possui direito a  por ter faltado mais de 32 dias sem abono');
            return redirect()->route('IndexGerenciarFerias');
        }


        // Verifica o número de períodos de férias
        if ($formulario_de_ferias['numeroPeriodoDeFerias'] == 1) {

            // Condições para um único período de férias
            $data_inicio_formulario = Carbon::parse($formulario_de_ferias["data_inicio_0"]);
            $data_fim_formulario = Carbon::parse($formulario_de_ferias["data_fim_0"]);
            $dias_de_ferias_utilizadas = $data_inicio_formulario->diffInDays($data_fim_formulario) + 1;
            $data_de_saida_para_as_ferias = Carbon::parse($data_inicio_formulario)->dayOfWeek;


            // Verifica se o número de dias utilizados excede os dias de direito do funcionário
            if ($dias_de_ferias_utilizadas > $diasDeDireitoDoFuncionario) {
                $dias_excedentes = $dias_de_ferias_utilizadas - $diasDeDireitoDoFuncionario;
                app('flasher')->addError("Foram utilizados $dias_excedentes dias a mais. Deveria assim retornar dia " . Carbon::parse($data_inicio_formulario->addDays(29))->format('d-m-y'));
            } // Verifica se o número de dias utilizados é inferior aos dias de direito do funcionário
            elseif ($dias_de_ferias_utilizadas < $diasDeDireitoDoFuncionario) {
                $dias_restantes = $diasDeDireitoDoFuncionario - $dias_de_ferias_utilizadas;
                app('flasher')->addError("Não foram utilizados todos os dias que tem direito, ainda é preciso utilizar $dias_restantes dias. Deveria assim retornar dia " . Carbon::parse($data_inicio_formulario->addDays(29))->format('d-m-y'));
            } // Verifica se a data de início das férias é anterior ao início do período de licença
            elseif ($data_inicio_formulario < $ferias->dt_inicio_periodo_de_licenca) {
                app('flasher')->addError('A data inicial do período de férias é inferior ao início do seu período de licença que começa no dia ' . Carbon::parse($ferias->fim_periodo_aquisitivo)->format('d/M/Y'));
            } //Verifica se a data final é depois do periodo de licensa
            elseif ($data_fim_formulario > $ferias->dt_fim_periodo_de_licenca) {
                app('flasher')->addError('Data Final depois do periodo de licensa');
            } // Verifica se a data de fim é anterior à data de início
            elseif ($data_fim_formulario < $data_inicio_formulario) {
                app('flasher')->addError('Você colocou uma data de fim excedendo a data de início');
            } //Verifica se a data inicia das ferias ocore em uma sexta-feira
            elseif ($data_de_saida_para_as_ferias == 5) {
                app('flasher')->addError("Sua data de saida, antecede dois dias antes do repouso semanal remunerado");
            } elseif ($dia_limite_para_inicio_do_periodo_de_ferias <= $data_inicio_formulario) {
                app('flasher')->addError('Uma das datas iniciais que selecionou ultrapassa a data limite para inicio das férias: ' . $dia_limite_para_inicio_do_periodo_de_ferias);
            } //Insere no banco e coloca no historico
            else {
                DB::table('ferias')
                    ->where('id', $ferias->id)
                    ->update([
                        'dt_ini_a' => $data_inicio_formulario,
                        'dt_fim_a' => $data_fim_formulario,
                        'dt_ini_b' => null, 'dt_fim_b' => null,
                        'dt_ini_c' => null, 'dt_fim_c' => null,
                        'motivo_retorno' => null,
                        'adianta_13sal' => $request->input('adiantaDecimoTerceiro'),
                        'status_pedido_ferias' => 3,
                        'nr_dias_per_a' => $data_inicio_formulario->diffInDays($data_fim_formulario) + 1,
                        'vendeu_ferias' => isset($formulario_de_ferias["vendeFerias"]) ? $formulario_de_ferias["vendeFerias"] : null,
                        'venda_um_terco' => (int)$request->input('periodoDeVendaDeFerias')

                    ]);
                DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $ferias->id, 'motivo_retorno' => 'Envio do Formulário', 'data_de_acontecimento' => Carbon::today()->toDateString()]);
                $ferias = DB::table('ferias')
                    ->where('ferias.id', $ferias->id)
                    ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                    ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                    ->select('pessoas.nome_completo')->first();


                app('flasher')->addCreated($ferias->nome_completo . ' teve férias adicionadas com sucesso.');
                return redirect()->route('IndexGerenciarFerias');
            }

        } //Condicoes para segundo caso
        elseif ($formulario_de_ferias['numeroPeriodoDeFerias'] == 2) {
            // Condições para dois períodos de férias
            $data_inicio_primeiro_periodo = Carbon::parse($formulario_de_ferias["data_inicio_0"]);
            $data_fim_primeiro_periodo = Carbon::parse($formulario_de_ferias["data_fim_0"]);
            $data_inicio_segundo_periodo = Carbon::parse($formulario_de_ferias["data_inicio_1"]);
            $data_fim_segundo_periodo = Carbon::parse($formulario_de_ferias["data_fim_1"]);
            $dia_da_semana_de_saida_do_primeiro_periodo = Carbon::parse($data_inicio_primeiro_periodo)->dayOfWeek;
            $dia_da_semana_de_saida_do_segundo_periodo = Carbon::parse($data_inicio_segundo_periodo)->dayOfWeek;
            $dias_de_ferias_utilizadas = ($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1) + ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1);

            // Verifica se a data inicial do primeiro período é maior que a data final do primeiro período
            if ($data_inicio_primeiro_periodo > $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Inicial do Primeiro Período é maior que a Data Final do Primeiro Período');
            } // Verifica se a data inicial do segundo período é maior que a data final do segundo período
            elseif ($data_inicio_segundo_periodo > $data_fim_segundo_periodo) {
                app('flasher')->addError('A Data Inicial do Segundo Período é maior que a Data Final do Segundo Período');
            } // Verifica se a data final do segundo período é anterior à data de início ou à data final do primeiro período
            elseif ($data_fim_segundo_periodo < $data_inicio_primeiro_periodo || $data_fim_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Final do Segundo Período é anterior ao Primeiro Período');
            } // Verifica se a data inicial do segundo período está dentro do primeiro período
            elseif ($data_inicio_segundo_periodo > $data_inicio_primeiro_periodo && $data_inicio_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Inicial do Segundo Período entra em conflito com o Primeiro Período');
            } // Verifica se a data final do segundo período está dentro do primeiro período
            elseif ($data_fim_segundo_periodo > $data_inicio_primeiro_periodo && $data_fim_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Final do Segundo Período entra em conflito com o Primeiro Período');
            } // Verifica se o segundo período está completamente dentro do primeiro período
            elseif ($data_inicio_segundo_periodo < $data_inicio_primeiro_periodo && $data_fim_segundo_periodo > $data_fim_primeiro_periodo) {
                app('flasher')->addError('O Segundo Período está completamente dentro do Primeiro Período');
            } // Verifica se o segundo período inicia e termina antes do primeiro período
            elseif ($data_inicio_segundo_periodo < $data_inicio_primeiro_periodo && $data_fim_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('O Segundo Período inicia antes e termina antes do Primeiro Período');
            } // Verifica se o segundo período inicia durante e termina após o primeiro período
            elseif ($data_inicio_segundo_periodo > $data_inicio_primeiro_periodo && $data_inicio_segundo_periodo < $data_fim_primeiro_periodo && $data_fim_segundo_periodo > $data_fim_primeiro_periodo) {
                app('flasher')->addError('O Segundo Período inicia durante o Primeiro Período e termina após o seu término');
            } // Verifica se o segundo período inicia antes e termina antes do primeiro período
            elseif ($data_inicio_segundo_periodo < $data_inicio_primeiro_periodo && $data_fim_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('O Segundo Período inicia antes do Primeiro Período e termina antes do seu término');
            } // Verifica se o segundo período inicia durante e termina antes do primeiro período
            elseif ($data_inicio_segundo_periodo > $data_inicio_primeiro_periodo && $data_inicio_segundo_periodo < $data_fim_primeiro_periodo && $data_fim_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('O Segundo Período inicia durante o Primeiro Período e termina antes do seu término');
            } //Verifica se o funcionario usou o seu tempo de ferias corretamente para menos
            elseif ($dias_de_ferias_utilizadas < $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Ainda não utilizou todos os dias de férias. Utilizou:' . ($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1) . 'no primeiro período.<br> E ' . ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1) . ' no segundo período');
            } //Verifica se o funcionario utilizou dias a mais
            elseif ($dias_de_ferias_utilizadas > $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Utilizou dias de férias a mais. <br> Utilizou:' . ($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1) . 'no primeiro período.<br> E ' . ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1) . ' no segundo período');
            } //Verifica se a data inicia do primeiro periodo de ferias ocorre em uma sexta-feira
            elseif ($dia_da_semana_de_saida_do_primeiro_periodo == 5) {
                app('flasher')->addError('A data inicial do primeiro periodo ocorre dois dias antes do descanso semanal remunerado');
            } //Verifica se a data inicia do primeiro periodo de ferias ocorre em uma sexta-feira
            elseif ($dia_da_semana_de_saida_do_segundo_periodo == 5) {
                app('flasher')->addError('A data inicial do segundo periodo ocorre dois dias antes do descanso semanal remunerado');
            } //Verifica se o primeiro periodo é menor que cinco dias
            elseif (Carbon::parse($data_inicio_primeiro_periodo)->diffInDays($data_fim_primeiro_periodo) < 5) {
                app('flasher')->addError('O primeiro periodo é inferior a 5 dias');
            } //Verifica se o primeiro periodo é menor que cinco dias
            elseif (Carbon::parse($data_inicio_segundo_periodo)->diffInDays($data_fim_segundo_periodo) < 5) {
                app('flasher')->addError('O segundo periodo é inferior a 5 dias');
            } elseif ($dia_limite_para_inicio_do_periodo_de_ferias < $data_inicio_primeiro_periodo or $dia_limite_para_inicio_do_periodo_de_ferias < $data_inicio_segundo_periodo) {
                app('flasher')->addError('Uma das datas iniciais que selecionou ultrapassa a data limite para inicio das férias: ' . $dia_limite_para_inicio_do_periodo_de_ferias);
            } else {
                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio_primeiro_periodo,
                    'dt_fim_a' => $data_fim_primeiro_periodo,
                    'dt_ini_b' => $data_inicio_segundo_periodo,
                    'dt_fim_b' => $data_fim_segundo_periodo,
                    'dt_ini_c' => null, 'dt_fim_c' => null,
                    'motivo_retorno' => null,
                    'adianta_13sal' => $adiantar_decimo_terceiro,
                    'status_pedido_ferias' => 3,
                    'nr_dias_per_a' => $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo),
                    'nr_dias_per_b' => $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo),
                    'vendeu_ferias' => isset($formulario_de_ferias["vendeFerias"]) ? $formulario_de_ferias["vendeFerias"] : null,
                    'venda_um_terco' => (int)$request->input('periodoDeVendaDeFerias')
                ]);
                DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $ferias->id, 'motivo_retorno' => 'Envio do Formulário', 'data_de_acontecimento' => Carbon::today()->toDateString()]);
                $ferias = DB::table('ferias')
                    ->where('ferias.id', $ferias->id)
                    ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                    ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                    ->select('pessoas.nome_completo')->first();
                app('flasher')->addCreated($ferias->nome_completo . ' teve férias adicionadas com sucesso.');
                return redirect()->route('IndexGerenciarFerias');
            }
        } elseif ($formulario_de_ferias['numeroPeriodoDeFerias'] == 3) {
            // Condições para três períodos de férias
            $data_inicio_primeiro_periodo = Carbon::parse($formulario_de_ferias["data_inicio_0"]);
            $data_fim_primeiro_periodo = Carbon::parse($formulario_de_ferias["data_fim_0"]);
            $data_inicio_segundo_periodo = Carbon::parse($formulario_de_ferias["data_inicio_1"]);
            $data_fim_segundo_periodo = Carbon::parse($formulario_de_ferias["data_fim_1"]);
            $data_inicio_terceiro_periodo = Carbon::parse($formulario_de_ferias["data_inicio_2"]);
            $data_fim_terceiro_periodo = Carbon::parse($formulario_de_ferias["data_fim_2"]);

            $dia_da_semana_de_saida_do_primeiro_periodo = Carbon::parse($data_inicio_primeiro_periodo)->dayOfWeek;
            $dia_da_semana_de_saida_do_segundo_periodo = Carbon::parse($data_inicio_segundo_periodo)->dayOfWeek;
            $dia_da_semana_de_saida_do_terceiro_periodo = Carbon::parse($data_inicio_terceiro_periodo)->dayOfWeek;

            $dias_de_ferias_utilizadas = $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 3;

            // Verifica se a data inicial do primeiro período é maior que a data final do primeiro período
            if ($data_inicio_primeiro_periodo > $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Inicial do Primeiro Período é maior que a Data Final do Primeiro Período');
            } // Verifica se a data inicial do segundo período é maior que a data final do segundo período
            elseif ($data_inicio_segundo_periodo > $data_fim_segundo_periodo) {
                app('flasher')->addError('A Data Inicial do Segundo Período é maior que a Data Final do Segundo Período');
            } // Verifica se a data inicial do terceiro período é maior que a data final do terceiro período
            elseif ($data_inicio_terceiro_periodo > $data_fim_terceiro_periodo) {
                app('flasher')->addError('A Data Inicial do Terceiro Período é maior que a Data Final do Terceiro Período');
            } // Verifica se a data final do segundo período é anterior à data de início ou à data final do primeiro período
            elseif ($data_fim_segundo_periodo < $data_inicio_primeiro_periodo || $data_fim_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Final do Segundo Período é anterior ao Primeiro Período');
            } // Verifica se a data inicial do segundo período está dentro do primeiro período
            elseif ($data_inicio_segundo_periodo > $data_inicio_primeiro_periodo && $data_inicio_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Inicial do Segundo Período entra em conflito com o Primeiro Período');
            } // Verifica se a data final do segundo período está dentro do primeiro período
            elseif ($data_fim_segundo_periodo > $data_inicio_primeiro_periodo && $data_fim_segundo_periodo < $data_fim_primeiro_periodo) {
                app('flasher')->addError('A Data Final do Segundo Período entra em conflito com o Primeiro Período');
            } // Verifica se a data inicial do terceiro período é anterior à data final do segundo período
            elseif ($data_inicio_terceiro_periodo < $data_fim_segundo_periodo) {
                app('flasher')->addError('A Data Inicial do Terceiro Período é menor que a Data Final do Segundo Período');
            } // Verifica se a data final do terceiro período é anterior à data de início ou à data final do segundo período
            elseif ($data_fim_terceiro_periodo < $data_inicio_segundo_periodo || $data_fim_terceiro_periodo < $data_fim_segundo_periodo) {
                app('flasher')->addError('A Data Final do Terceiro Período é anterior ao Segundo Período');
            } // Verifica se a data inicial do terceiro período está dentro do segundo período
            elseif ($data_inicio_terceiro_periodo > $data_inicio_segundo_periodo && $data_inicio_terceiro_periodo < $data_fim_segundo_periodo) {
                app('flasher')->addError('A Data Inicial do Terceiro Período entra em conflito com o Segundo Período');
            } // Verifica se a data final do terceiro período está dentro do segundo período
            elseif ($data_fim_terceiro_periodo > $data_inicio_segundo_periodo && $data_fim_terceiro_periodo < $data_fim_segundo_periodo) {
                app('flasher')->addError('A Data Final do Terceiro Período entra em conflito com o Segundo Período');
            } //Verifica se o funcionario utilizou dias a mais
            elseif ($dias_de_ferias_utilizadas > $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Utilizou dias de férias a mais. <br> Utilizou:' . ($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1) . 'no primeiro período.<br> E ' . ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1) . ' no segundo . <br>' . ($data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1) . " no terceiro período");
            } //Verifica se o funcionario utililizou dias a menos
            elseif ($dias_de_ferias_utilizadas < $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Ainda não utilizou todos os dias de ferías. <br> Utilizou:' . ($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1) . 'no primeiro período.<br> E ' . ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1) . ' no segundo . <br>' . ($data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1) . " no terceiro período");
            } //Verifica se o primeiro periodo ocore em uma sexta
            elseif ($dia_da_semana_de_saida_do_primeiro_periodo == 5) {
                app('flasher')->addError('A data inicial do primeiro periodo ocorre dois dias antes do descanso semanal remunerado');
            } //Verifica se o segundo periodo ocore em uma sexta
            elseif ($dia_da_semana_de_saida_do_segundo_periodo == 5) {
                app('flasher')->addError('A data inicial do segundo periodo ocorre dois dias antes do descanso semanal remunerado');
            } //Verifica se o terceiro periodo ocore em uma sexta
            elseif ($dia_da_semana_de_saida_do_terceiro_periodo == 5) {
                app('flasher')->addError('A data inicial do terceiro período ocorre dois dias antes do descanso semanal remunerado');
            } elseif ($dia_limite_para_inicio_do_periodo_de_ferias <= $data_inicio_primeiro_periodo or $dia_limite_para_inicio_do_periodo_de_ferias <= $data_inicio_segundo_periodo or $dia_limite_para_inicio_do_periodo_de_ferias <= $data_inicio_terceiro_periodo) {
                app('flasher')->addError('Uma das datas iniciais que selecionou ultrapassa a data limite para inicio das férias: ' . $dia_limite_para_inicio_do_periodo_de_ferias);
            } elseif (($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1 >= 15) || ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1 >= 15) || ($data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1) >= 15) {
                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio_primeiro_periodo,
                    'dt_fim_a' => $data_fim_primeiro_periodo,
                    'dt_ini_b' => $data_inicio_segundo_periodo,
                    'dt_fim_b' => $data_fim_segundo_periodo,
                    'dt_ini_c' => $data_inicio_terceiro_periodo,
                    'dt_fim_c' => $data_fim_terceiro_periodo,
                    'adianta_13sal' => $adiantar_decimo_terceiro,
                    'motivo_retorno' => null, 'status_pedido_ferias' => 3,
                    'nr_dias_per_a' => $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo),
                    'nr_dias_per_b' => $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo),
                    'nr_dias_per_c' => $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo),
                    'vendeu_ferias' => isset($formulario_de_ferias["vendeFerias"]) ? $formulario_de_ferias["vendeFerias"] : null,
                    'venda_um_terco' => (int)$request->input('periodoDeVendaDeFerias')
                ]);
                $ferias = DB::table('ferias')
                    ->where('ferias.id', $ferias->id)
                    ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                    ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                    ->select('pessoas.nome_completo')->first();


                app('flasher')->addCreated($ferias->nome_completo . ' teve férias adicionadas com sucesso.');
                return redirect()->route('IndexGerenciarFerias');
            } else {
                app('flasher')->addError('É essencial que pelo menos um periodos tenha o minimo de 15 dias.');
            }
        }
        return redirect()->route('IndexGerenciarFerias');
    }

    public
    function formulario_recusa_periodo_de_ferias($id)
    {
        try {
            $periodos_aquisitivos = DB::table('ferias')->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')->select('pessoas.nome_completo as nome_completo_funcionario', 'pessoas.id as id_pessoa', 'ferias.dt_ini_a', 'ferias.dt_fim_a', 'ferias.dt_ini_b', 'ferias.dt_fim_b', 'ferias.dt_ini_c', 'ferias.dt_fim_c', 'ferias.motivo_retorno', 'ferias.id as id_ferias', 'funcionarios.dt_inicio', 'ferias.ano_de_referencia', 'ferias.id_funcionario', 'status_pedido_ferias.id as id_status_pedido_ferias', 'status_pedido_ferias.nome as status_pedido_ferias')->where('ferias.id', '=', $id)->first();

            return view('ferias.recusa-ferias', compact('periodos_aquisitivos', 'id'));
        } catch (Exception $exception) {
            DB::rollBack();
            app('flasher')->addError("Houve um erro inesperado: #" . $exception->getCode());
            return redirect()->route('IndexGerenciarFerias');
        }
    }

    public
    function recusa_pedido_de_ferias(Request $request, $id)
    {
        try {
            $request->input('motivo_da_recusa');

            DB::table('ferias')->where('id', $id)->update(['motivo_retorno' => $request->input('motivo_da_recusa'), 'status_pedido_ferias' => 5]);

            DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $id, 'motivo_retorno' => $request->input('motivo_da_recusa'), 'data_de_acontecimento' => Carbon::today()->toDateString()]);
            app('flasher')->addSuccess('Recusado com sucesso.');
        } catch (Exception $exception) {
            app('flasher')->addError("Houve um erro inesperado: #" . $exception->getCode());
            DB::rollBack();
        }

        return redirect()->route('AdministrarFerias');
    }

    public
    function enviarFerias(Request $request)
    {
        try {
            $numeros_checkboxes = $request->input('checkbox');

            if (empty($request->input('checkbox'))) {
                app('flasher')->addError("Nenhum periodo de ferias foi selecionado para ser enviado.");

                return redirect()->back();
            }

            $ferias_funcionarios = DB::table('ferias')
                ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
                ->select(
                    'pessoas.nome_completo as nome_completo_funcionario',
                    'pessoas.id as id_pessoa',
                    'ferias.dt_ini_a',
                    'ferias.dt_fim_a',
                    'ferias.dt_ini_b',
                    'ferias.dt_fim_b',
                    'ferias.dt_ini_c',
                    'ferias.dt_fim_c',
                    'ferias.motivo_retorno',
                    'ferias.id as id_ferias',
                    'funcionarios.dt_inicio',
                    'ferias.ano_de_referencia',
                    'ferias.id_funcionario',
                    'status_pedido_ferias.id as id_status_pedido_ferias',
                    'status_pedido_ferias.nome as status_pedido_ferias'
                )->WhereIn('ferias.id', $numeros_checkboxes)->get();
            foreach ($ferias_funcionarios as $ferias_funcionario) {
                if (empty($ferias_funcionario->dt_ini_a)) {
                    app('flasher')->addError('Foi feita uma tentativa de enviar as ferias de ' . $ferias_funcionario->nome_completo_funcionario . ', porém as mesmas não foram preenchidas.');
                    return redirect()->route('IndexGerenciarFerias');
                }
            }
            foreach ($ferias_funcionarios as $ferias_funcionario) {
                DB::table('ferias')->where('id', '=', $ferias_funcionario->id_ferias)->update(['status_pedido_ferias' => 4]);
            }
            DB::commit();
            app('flasher')->addSuccess("Ferias Enviadas com Sucesso!");
            return redirect()->back();
        } catch (Exception $exception) {
            app('flasher')->addError("Houve um erro inesperado: #" . $exception->getCode());
            DB::rollBack();
            return redirect()->back();
        }
    }

    public
    function reabrirFormulario($id)
    {
        try {
            DB::table('ferias')->where('id', $id)->update(['status_pedido_ferias' => 1]);
            $nome = DB::table('ferias')
                ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                ->where('ferias.id', '=', $id)
                ->select('pessoas.nome_completo', 'ferias.ano_de_referencia')->first();

            DB::table('hist_recusa_ferias')->insert(['id_periodo_de_ferias' => $id, 'motivo_retorno' => 'Solicitada Reabertura do Formulario pelo funcionário', 'data_de_acontecimento' => Carbon::today()->toDateString()]);
            app('flasher')->addInfo('Ferias Do funcionario' . $nome->nome_completo . ' referentes a ' . (intval($nome->ano_de_referencia) + 1) . '-' . (intval($nome->ano_de_referencia) + 2) . ' foram reabertas');
            return redirect()->back();
        } catch (Exception $exception) {
            DB::rollBack();
            app('flasher')->addError("Houve um erro inesperado: #" . $exception->getCode());
            return redirect()->back();
        }
    }

    public function EnviaPeriodoDeFeriasIndividualmente($id)
    {
        try {
            $periodo_de_ferias = $ferias_funcionarios = DB::table('ferias')
                ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
                ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
                ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
                ->select(
                    'pessoas.nome_completo as nome_completo_funcionario',
                    'pessoas.id as id_pessoa',
                    'ferias.dt_ini_a',
                    'ferias.dt_fim_a',
                    'ferias.dt_ini_b',
                    'ferias.dt_fim_b',
                    'ferias.dt_ini_c',
                    'ferias.dt_fim_c',
                    'ferias.motivo_retorno',
                    'ferias.id as id_ferias',
                    'funcionarios.dt_inicio',
                    'ferias.ano_de_referencia',
                    'ferias.id_funcionario',
                    'status_pedido_ferias.id as id_status_pedido_ferias',
                    'status_pedido_ferias.nome as status_pedido_ferias'
                )->where('ferias.id', '=', $id)->first();

            if ($periodo_de_ferias->dt_ini_a == null) {
                app('flasher')->addError('Foi feita uma tentativa de enviar as ferias de ' . $periodo_de_ferias->nome_completo_funcionario . ', porém as mesmas não foram preenchidas.');
                return redirect()->route('IndexGerenciarFerias');
            } else {
                DB::table('ferias')->where('id', '=', $periodo_de_ferias->id_ferias)->update(['status_pedido_ferias' => 4]);
                DB::commit();
                app('flasher')->addSuccess("Ferias Enviadas com Sucesso!");
                return redirect()->back();
            }
        } catch (Exception $exception) {
            app('flasher')->addError("Houve um erro inesperado: #" . $exception->getCode());
            DB::rollBack();
            return redirect()->back();
        }
    }

    public
    function retornaPeriodoFerias($ano, $nome, $setor, $status)
    {
        // Realize sua lógica para buscar os dados com base nos parâmetros recebidos
        $periodo_aquisitivo = DB::table('ferias')
            ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
            ->join('setor as s', 's.id', '=', 'id_setor')
            ->select(
                'pessoas.nome_completo as nome_completo_funcionario',
                'pessoas.id as id_pessoa',
                'ferias.dt_ini_a',
                'ferias.dt_fim_a',
                'ferias.dt_ini_b',
                'ferias.dt_fim_b',
                'ferias.dt_ini_c',
                'ferias.dt_fim_c',
                'ferias.motivo_retorno',
                'ferias.id as id_ferias',
                'ferias.venda_um_terco',
                'funcionarios.dt_inicio',
                'ferias.ano_de_referencia',
                'ferias.id_funcionario',
                'ferias.adianta_13sal',
                'status_pedido_ferias.id as id_status_pedido_ferias',
                'status_pedido_ferias.nome as status_pedido_ferias',
                's.sigla as sigla_do_setor',
                's.id as id_do_setor'
            );

        if ($nome !== "null") {
            $periodo_aquisitivo = $periodo_aquisitivo->where('pessoas.nome_completo', 'ilike', '%' . $nome . '%');
        }

        if ($ano !== "null") {
            $periodo_aquisitivo = $periodo_aquisitivo->where('ferias.ano_de_referencia', '=', $ano);
        }
        if ($setor !== "null") {
            $periodo_aquisitivo = $periodo_aquisitivo->where('s.id', '=', $setor);
        }
        if ($status !== "null") {
            $periodo_aquisitivo = $periodo_aquisitivo->where('status_pedido_ferias.id', '=', $status);
        }

        $periodo_aquisitivo = $periodo_aquisitivo->get();
        return response()->json($periodo_aquisitivo);
    }
}
