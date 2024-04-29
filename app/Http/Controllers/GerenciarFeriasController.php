<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GerenciarFeriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->input('search')) {
                $ano_referente = $request->input('search');
            } else {
                $ano_referente = Carbon::now()->year - 1;
            }


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
                    'funcionarios.dt_inicio',
                    'ferias.ano_de_referencia',
                    'ferias.id_funcionario',
                    'status_pedido_ferias.id as id_status_pedido_ferias',
                    'status_pedido_ferias.nome as status_pedido_ferias',
                    'funcionarios.id_setor'
                )
                ->where('funcionarios.id_setor', session('usuario.setor'))
                ->get();


            $anos_possiveis = DB::table('ferias')
                ->select('ano_de_referencia')
                ->groupBy('ano_de_referencia')
                ->get();

            DB::commit();
            return view('ferias.gerenciar-ferias', compact('periodo_aquisitivo', 'ano_referente', 'anos_possiveis'));


        } catch (Exception $e) {
            app('flasher')->addError("Houve um erro inesperado: #" . $e->getCode());
            DB::rollBack();
            return redirect()->back();

        }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id_ferias)
    {

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
                'ferias.dt_inicio_periodo_de_licenca'
            )
            ->where('ferias.id', $id_ferias)
            ->first();


        return view('ferias.incluir-ferias', compact('ano_referente', "periodo_aquisitivo", 'id_ferias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
    }

    /**
     * Display the specified resource.
     */
    /*Historico de Devoluções*/
    public function show(string $id)
    {

        $ano_referencia = Carbon::now()->year - 1;

        $periodo_de_ferias = DB::table('ferias')
            ->where('id', '=', $id)
            ->first();


        $funcionario = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->where('funcionarios.id', '=', $periodo_de_ferias->id_funcionario)
            ->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'pessoas.nome_completo', 'funcionarios.dt_inicio')
            ->first();


        $historico_recusa_ferias = DB::table('hist_recusa_ferias')
            ->where('id_periodo_de_ferias', '=', $id)
            ->get();

        if (empty($historico_recusa_ferias)) {
            app('flasher')->addInfo("Não há nenhuma informação das férias do funcionário:  $funcionario->nome_completo.");
            return redirect()->back();
        }


        return view('ferias.historico-ferias', compact('periodo_de_ferias', 'historico_recusa_ferias', 'funcionario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function InsereERetornaFuncionarios(Request $request)
    {
        $ano_referencia = $request->input('ano_referencia');
        if (empty($ano_referencia)) {
            $ano_referencia = Carbon::now()->year - 1;
        } else {
            $ano_referencia = $request->input('ano_referencia');
        }


        $data_do_ultimo_ano = Carbon::now()->subYear()->endOfYear()->toDateString();


        $funcionarios = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->where('dt_inicio', '<', $data_do_ultimo_ano)
            ->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'funcionarios.dt_inicio as data_de_inicio', 'pessoas.nome_completo')
            ->get();

        foreach ($funcionarios as $funcionario) {
            $data_inicio = Carbon::parse($funcionario->data_de_inicio);


            $data_inicio_periodo_aquisitivo = $data_inicio->copy()->subYear()->year($ano_referencia - 1)->toDateString();
            $data_fim_periodo_aquisitivo = $data_inicio->copy()->subYear()->year($ano_referencia)->subDay()->toDateString();
            $funcionario->data_inicio_periodo_aquisitivo = $data_inicio_periodo_aquisitivo;
            $funcionario->data_fim_periodo_aquisitivo = $data_fim_periodo_aquisitivo;

            $funcionario->data_inicio_periodo_de_gozo = $data_inicio->copy()->addYear()->year($ano_referencia + 1)->toDateString();
            $funcionario->data_fim_periodo_de_gozo = $data_inicio->copy()->addYear()->year($ano_referencia + 2)->subDay()->toDateString();
        }

        $ferias = DB::table('ferias')
            ->where('ano_de_referencia', '=', $ano_referencia)
            ->get();

        if ($ferias->isEmpty()) {
            foreach ($funcionarios as $funcionario) {
                $id_ferias = DB::table('ferias')
                    ->insertGetId([
                        'ano_de_referencia' => $ano_referencia,
                        'inicio_periodo_aquisitivo' => $funcionario->data_inicio_periodo_aquisitivo,
                        'fim_periodo_aquisitivo' => $funcionario->data_fim_periodo_aquisitivo,
                        'status_pedido_ferias' => 1,
                        'id_funcionario' => $funcionario->id_funcionario,
                        'dt_inicio_periodo_de_licenca' => $funcionario->data_inicio_periodo_de_gozo,
                        'dt_fim_periodo_de_licenca' => $funcionario->data_fim_periodo_de_gozo

                    ]);
                DB::table('hist_recusa_ferias')->insert([
                    'id_periodo_de_ferias' => $id_ferias,
                    'motivo_retorno' => "Criação do Formulario de Férias",
                    'data_de_acontecimento' => Carbon::now()->toDateString()
                ]);

            }
            app('flasher')->addSuccess("Periodo de ferias de " . $ano_referencia . "foi criado");
        } else {
            app('flasher')->addError("Já existe periodo e ferias criado");
        }
        return redirect()->route('AdministrarFerias');
    }

    public function administraferias(Request $request)
    {
        if ($request->input('search')) {
            $ano_referente = $request->input('search');
        } else {
            $ano_referente = Carbon::now()->year - 1;
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

            )
            ->where('ano_de_referencia', '=', $ano_referente)
            ->orderBy('sigla_do_setor')
            ->get();


        $anos_possiveis = DB::table('ferias')
            ->select('ano_de_referencia')
            ->groupBy('ano_de_referencia')
            ->get();
        $anos_inicial = DB::table('ferias')
            ->select('ano_de_referencia')
            ->groupBy('ano_de_referencia')
            ->first();
        $anos_final = DB::table('ferias')
            ->select('ano_de_referencia')
            ->groupBy('ano_de_referencia')
            ->orderBy('ano_de_referencia', 'desc')
            ->first();
        if (!empty($anos_inicial)) {
            $anoAnterior = intval($anos_inicial->ano_de_referencia) - 2;
            $doisAnosFrente = intval($anos_final->ano_de_referencia) + 5;
        } else {
            $anoAnterior = intval(Carbon::now()->subYear(2)->toDateString());
            $doisAnosFrente = intval(Carbon::now()->addYear(5)->toDateString());

        }


        $listaAnos = range($anoAnterior, $doisAnosFrente);


        return view('ferias.administrar-ferias', compact('periodo_aquisitivo', 'anos_possiveis', 'listaAnos'));
    }

    public function autorizarferias($id)
    {

        $periodo_de_ferias = DB::table('ferias')
            ->leftJoin('funcionarios', 'ferias.id_funcionario', '=', 'funcionarios.id')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->join('status_pedido_ferias', 'ferias.status_pedido_ferias', '=', 'status_pedido_ferias.id')
            ->select(
                'pessoas.nome_completo as nome_completo_funcionario',

            )
            ->where('ferias.id', '=', $id)
            ->first();
        DB::table('ferias')->where('id', '=', $id)->update([
            'status_pedido_ferias' => 6
        ]);
        DB::table('hist_recusa_ferias')->insert([
            'id_periodo_de_ferias' => $id,
            'motivo_retorno' => "Sucesso",
            'data_de_acontecimento' => Carbon::today()->toDateString()
        ]);
        app('flasher')->addSuccess("As ferias do funcionario $periodo_de_ferias->nome_completo_funcionario foram autorizadas.");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Obtém os dados do formulário de férias
        $formulario_de_ferias = $request->all();


        $adiantar_decimo_terceiro = false;
        $ferias = DB::table('ferias')
            ->where('id', $id)
            ->first();

        // Obtém o ano de referência
        $ano_referente = $ferias->ano_de_referencia;

        // Obtém informações do funcionário
        $funcionario = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'pessoas.nome_completo', 'funcionarios.dt_inicio')
            ->first();


        // Obtém informações sobre as férias do funcionário


        // Calcula os dias de direito do funcionário (exemplo: 30 dias de férias - dias de falta)
        $faltas = 0;

        $atestados = DB::table('afastamento')
            ->join('tp_afastamento', 'afastamento.id_tp_afastamento', '=', 'tp_afastamento.id')
            ->where('dt_inicio', '>=', $ferias->inicio_periodo_aquisitivo)
            ->where('dt_fim', '<=', $ferias->fim_periodo_aquisitivo)
            ->select('tp_afastamento.limite',
                'afastamento.qtd_dias')
            ->get();

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

            DB::table('ferias')
                ->where('id', '=', $ferias->id)
                ->update([
                    'status_pedido_ferias' => 6,
                    'motivo_retorno' => "O funcionario não possui direito a  por ter faltado mais de 32 dias sem abono"
                ]);
            DB::table('hist_recusa_ferias')->insert([
                'id_periodo_de_ferias' => $id,
                'motivo_retorno' => "O funcionario não possui direito a  por ter faltado mais de 32 dias sem abono",
                'data_de_acontecimento' => Carbon::today()->toDateString()
            ]);
            app('flasher')->addError('O funcionario não possui direito a  por ter faltado mais de 32 dias sem abono');
            return redirect()->route('IndexGerenciarFerias');
        }

        $diasDeDireitoDoFuncionario = 30;

        // Verifica o número de períodos de férias
        if ($formulario_de_ferias['numeroPeriodoDeFerias'] == 1) {

            // Condições para um único período de férias
            $data_inicio = Carbon::parse($formulario_de_ferias["data_inicio_0"]);
            $data_fim = Carbon::parse($formulario_de_ferias["data_fim_0"]);
            $dias_de_ferias_utilizadas = $data_inicio->diffInDays($data_fim) + 1;
            $data_de_saida_para_as_ferias = Carbon::parse($data_inicio)->dayOfWeek;


            // Verifica se o número de dias utilizados excede os dias de direito do funcionário
            if ($dias_de_ferias_utilizadas > $diasDeDireitoDoFuncionario) {
                $dias_excedentes = $dias_de_ferias_utilizadas - $diasDeDireitoDoFuncionario;
                app('flasher')->addError("Foram utilizados $dias_excedentes dias a mais. Deveria assim retornar dia " . Carbon::parse($data_inicio->addDays(29))->format('d-m-y'));
            } // Verifica se o número de dias utilizados é inferior aos dias de direito do funcionário
            elseif ($dias_de_ferias_utilizadas < $diasDeDireitoDoFuncionario) {
                $dias_restantes = $diasDeDireitoDoFuncionario - $dias_de_ferias_utilizadas;
                app('flasher')->addError("Não foram utilizados todos os dias que tem direito, ainda é preciso utilizar $dias_restantes dias. Deveria assim retornar dia " . Carbon::parse($data_inicio->addDays(29))->format('d-m-y'));
            } // Verifica se a data de início das férias é anterior ao início do período de licença
            elseif ($data_inicio < $ferias->dt_inicio_periodo_de_licenca) {
                app('flasher')->addError('A data inicial do período de férias é inferior ao início do seu período de licença que começa no dia ' . Carbon::parse($ferias->fim_periodo_aquisitivo)->format('dd/MM/yyyy'));
            } //Verifica se a data final é depois do periodo de licensa
            elseif ($data_fim > $ferias->dt_fim_periodo_de_licenca) {
                app('flasher')->addError('Data Final depois do periodo de licensa');
            } // Verifica se a data de fim é anterior à data de início
            elseif ($data_fim < $data_inicio) {
                app('flasher')->addError('Você colocou uma data de fim excedendo a data de início');
            } //Verifica se a data inicia das ferias ocore em uma sexta-feira
            elseif ($data_de_saida_para_as_ferias == 5) {
                app('flasher')->addError("Sua data de saida, antecede dois dias antes do repouso semanal remunerado");
            } else {
                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio,
                    'dt_fim_a' => $data_fim,
                    'dt_ini_b' => null,
                    'dt_fim_b' => null,
                    'dt_ini_c' => null,
                    'dt_fim_c' => null,
                    'motivo_retorno' => null,
                    'adianta_13sal' => $request->input('adiantaDecimoTerceiro'),
                    'status_pedido_ferias' => 3,
                    'venda_um_terco' => (int)$request->input('periodoDeVendaDeFerias'),
                    'nr_dias_per_a' => $data_inicio->diffInDays($data_fim) + 1

                ]);
                app('flasher')->addCreated($funcionario->nome_completo . ' teve férias adicionadas com sucesso.');
            }
            return redirect()->route('IndexGerenciarFerias');
        } elseif ($formulario_de_ferias['numeroPeriodoDeFerias'] == 2) {
            // Condições para dois períodos de férias
            $data_inicio_primeiro_periodo = Carbon::parse($formulario_de_ferias["data_inicio_0"]);
            $data_fim_primeiro_periodo = Carbon::parse($formulario_de_ferias["data_fim_0"]);
            $data_inicio_segundo_periodo = Carbon::parse($formulario_de_ferias["data_inicio_1"]);
            $data_fim_segundo_periodo = Carbon::parse($formulario_de_ferias["data_fim_1"]);
            $dia_da_semana_de_saida_do_primeiro_periodo = Carbon::parse($data_inicio_primeiro_periodo)->dayOfWeek;
            $dia_da_semana_de_saida_do_segundo_periodo = Carbon::parse($data_inicio_segundo_periodo)->dayOfWeek;
            $dias_de_ferias_utilizadas = $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 2;

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
                app('flasher')->addError('Ainda não utilizou todos os dias de férias. Utilizou:' . $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) .
                    'no primeiro período.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) . ' no segundo período');
            } //Verifica se o funcionario utilizou dias a mais
            elseif ($dias_de_ferias_utilizadas > $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Utilizou dias de férias a mais. <br> Utilizou:' . $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) .
                    'no primeiro período.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) . ' no segundo período');
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
            } else {
                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio_primeiro_periodo,
                    'dt_fim_a' => $data_fim_primeiro_periodo,
                    'dt_ini_b' => $data_inicio_segundo_periodo,
                    'dt_fim_b' => $data_fim_segundo_periodo,
                    'dt_ini_c' => null,
                    'dt_fim_c' => null,
                    'motivo_retorno' => null,
                    'adianta_13sal' => $adiantar_decimo_terceiro,
                    'status_pedido_ferias' => 3,
                    'nr_dias_per_a' => $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo),
                    'nr_dias_per_b' => $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo),
                    'venda_um_terco' => (int)$request->input('periodoDeVendaDeFerias'),
                ]);
                app('flasher')->addCreated($funcionario->nome_completo . ' teve férias adicionadas com sucesso.');
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
                app('flasher')->addError('Utilizou dias de férias a mais. <br> Utilizou:' . $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1 .
                    'no primeiro período.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1 . ' no segundo . <br>' .
                    $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1 . " no terceiro período");
            } //Verifica se o funcionario utililizou dias a menos
            elseif ($dias_de_ferias_utilizadas < $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Ainda não utilizou todos os dias de ferías. <br> Utilizou:' . $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1 .
                    'no primeiro período.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1 . ' no segundo . <br>' .
                    $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1 . " no terceiro período");
            } //Verifica se o primeiro periodo ocore em uma sexta
            elseif ($dia_da_semana_de_saida_do_primeiro_periodo == 5) {
                app('flasher')->addError('A data inicial do primeiro periodo ocorre dois dias antes do descanso semanal remunerado');
            } //Verifica se o segundo periodo ocore em uma sexta
            elseif ($dia_da_semana_de_saida_do_segundo_periodo == 5) {
                app('flasher')->addError('A data inicial do segundo periodo ocorre dois dias antes do descanso semanal remunerado');
            }//Verifica se o terceiro periodo ocore em uma sexta
            elseif ($dia_da_semana_de_saida_do_terceiro_periodo == 5) {
                app('flasher')->addError('A data inicial do terceiro período ocorre dois dias antes do descanso semanal remunerado');
            } elseif (($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1 >= 15) || ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1 >= 15) || ($data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1) >= 15) {
                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio_primeiro_periodo,
                    'dt_fim_a' => $data_fim_primeiro_periodo,
                    'dt_ini_b' => $data_inicio_segundo_periodo,
                    'dt_fim_b' => $data_fim_segundo_periodo,
                    'dt_ini_c' => $data_inicio_terceiro_periodo,
                    'dt_fim_c' => $data_fim_terceiro_periodo,
                    'adianta_13sal' => $adiantar_decimo_terceiro,
                    'motivo_retorno' => null,
                    'status_pedido_ferias' => 3,
                    'nr_dias_per_a' => $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo),
                    'nr_dias_per_b' => $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo),
                    'nr_dias_per_c' => $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo),
                    'venda_um_terco' => (int)$request->input('periodoDeVendaDeFerias'),
                ]);
                app('flasher')->addCreated($funcionario->nome_completo . ' teve férias adicionadas com sucesso.');
            } else {
                app('flasher')->addError('É essencial que pelo menos um periodos tenha o minimo de 15 dias.');
            }
        }
        return redirect()->route('IndexGerenciarFerias');
    }

    public function formulario_recusa_periodo_de_ferias($id)
    {
        $periodos_aquisitivos = DB::table('ferias')
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
            )
            ->where('ferias.id', '=', $id)
            ->first();

        return view('ferias.recusa-ferias', compact('periodos_aquisitivos', 'id'));
    }

    public function recusa_pedido_de_ferias(Request $request, $id)
    {

        $request->input('motivo_da_recusa');

        DB::table('ferias')
            ->where('id', $id)
            ->update([
                'motivo_retorno' => $request->input('motivo_da_recusa'),
                'status_pedido_ferias' => 5
            ]);

        DB::table('hist_recusa_ferias')->insert([
            'id_periodo_de_ferias' => $id,
            'motivo_retorno' => $request->input('motivo_da_recusa'),
            'data_de_acontecimento' => Carbon::today()->toDateString()
        ]);

        return redirect()->route('AdministrarFerias');
    }

    public function enviarFerias(Request $request)
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
                )
                ->WhereIn('ferias.id', $numeros_checkboxes)
                ->get();

            foreach ($ferias_funcionarios as $ferias_funcionario) {

                if (empty($ferias_funcionario->dt_ini_a)) {
                    app('flasher')->addError('Foi feita uma tentativa de enviar as ferias de ' . $ferias_funcionario->nome_completo_funcionario . ', porém as mesmas não foram preenchidas.');
                    return redirect()->route('IndexGerenciarFerias');
                }
            }

            foreach ($ferias_funcionarios as $ferias_funcionario) {
                DB::table('ferias')
                    ->where('id', '=', $ferias_funcionario->id_ferias)
                    ->update([
                        'status_pedido_ferias' => 4
                    ]);
            }
            DB::commit();
            return redirect()->back();

        } catch (Exception $exception) {
            app('flasher')->addError("Houve um erro inesperado: #" . $exception->getCode());
            DB::rollBack();
            return redirect()->back();

        }
    }
}
