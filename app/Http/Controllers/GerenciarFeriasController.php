<?php

namespace App\Http\Controllers;

use App\Models\funcionario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class GerenciarFeriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
            ->where('ano_de_referencia', $ano_referente)
            ->get();

        $anos_possiveis = DB::table('ferias')
            ->select('ano_de_referencia')
            ->groupBy('ano_de_referencia')
            ->get();


        return view('ferias.gerenciar-ferias', compact('periodo_aquisitivo', 'ano_referente', 'anos_possiveis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
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
            ->where('ano_de_referencia', $ano_referente)
            ->where('id_funcionario', $id)
            ->first();


        return view('ferias.incluir-ferias', compact('ano_referente', "periodo_aquisitivo", 'id'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Obtém os dados do formulário de férias
        $formulario_de_ferias = $request->all();

        $adiantar_decimo_terceiro = false;

        // Calcula os dias de direito do funcionário (exemplo: 30 dias de férias - dias de falta)
        $diasDeDireitoDoFuncionario = 30 - ($faltas = 0);

        // Obtém o ano de referência
        $ano_referente = Carbon::now()->year - 1;

        // Obtém informações do funcionário
        $funcionario = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'pessoas.nome_completo', 'funcionarios.dt_inicio')
            ->first();

        // Obtém informações sobre as férias do funcionário
        $ferias = DB::table('ferias')
            ->where('id_funcionario', $id)
            ->where('ano_de_referencia', '=', $ano_referente)
            ->first();

        // Verifica o número de períodos de férias
        if ($formulario_de_ferias['numeroPeriodoDeFerias'] == 1) {

            // Condições para um único período de férias
            $data_inicio = Carbon::parse($formulario_de_ferias["data_inicio_0"]);
            $data_fim = Carbon::parse($formulario_de_ferias["data_fim_0"]);
            $dias_de_ferias_utilizadas = $data_inicio->diffInDays($data_fim) + 1;
            $data_de_retorno_em_dia_da_semana = Carbon::parse($data_fim)->format('n');

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
            } else {

                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio,
                    'dt_fim_a' => $data_fim,
                    'dt_ini_b' => null,
                    'dt_fim_b' => null,
                    'dt_ini_c' => null,
                    'dt_fim_c' => null,
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
                app('flasher')->addError('Ainda não utilizou todos os dias de ferias. Utilizou:' . $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) .
                    'no primeiro periodo.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) . ' no segundo periodo');
            } //Verifica se o funcionario utilizou dias a mais
            elseif ($dias_de_ferias_utilizadas > $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Utilizou dias de férias a mais. <br> Utilizou:' . $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) .
                    'no primeiro periodo.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) . ' no segundo periodo');
            } else {
                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio_primeiro_periodo,
                    'dt_fim_a' => $data_fim_primeiro_periodo,
                    'dt_ini_b' => $data_inicio_segundo_periodo,
                    'dt_fim_b' => $data_fim_segundo_periodo,
                    'dt_ini_c' => null,
                    'dt_fim_c' => null,
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
                    'no primeiro periodo.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1 . ' no segundo . <br>' .
                    $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1 . " no terceiro periodo");
            } //Verifica se o funcionario utililizou dias a menos
            elseif ($dias_de_ferias_utilizadas < $diasDeDireitoDoFuncionario) {
                app('flasher')->addError('Ainda não utilizou todos os dias de ferias. <br> Utilizou:' . $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1 .
                    'no primeiro periodo.<br> E ' . $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1 . ' no segundo . <br>' .
                    $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1 . " no terceiro periodo");
            } elseif (($data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo) + 1 >= 15) || ($data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo) + 1 >= 15) || ($data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo) + 1) >= 15) {
                DB::table('ferias')->where('id', $ferias->id)->update([
                    'dt_ini_a' => $data_inicio_primeiro_periodo,
                    'dt_fim_a' => $data_fim_primeiro_periodo,
                    'dt_ini_b' => $data_inicio_segundo_periodo,
                    'dt_fim_b' => $data_fim_segundo_periodo,
                    'dt_ini_c' => $data_inicio_terceiro_periodo,
                    'dt_fim_c' => $data_fim_terceiro_periodo,
                    'adianta_13sal' => $adiantar_decimo_terceiro,
                    'status_pedido_ferias' => 3,
                    'nr_dias_per_a' => $data_inicio_primeiro_periodo->diffInDays($data_fim_primeiro_periodo),
                    'nr_dias_per_b' => $data_inicio_segundo_periodo->diffInDays($data_fim_segundo_periodo),
                    'nr_dias_per_b' => $data_inicio_terceiro_periodo->diffInDays($data_fim_terceiro_periodo),
                    'venda_um_terco' => (int)$request->input('periodoDeVendaDeFerias'),
                ]);
                app('flasher')->addCreated($funcionario->nome_completo . ' teve férias adicionadas com sucesso.');
            } else {
                app('flasher')->addError('É essencial que pelo menos um periodos tenha o minimo de 15 dias.');
            }
        }
        return redirect()->route('IndexGerenciarFerias');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function InsereERetornaFuncionarios()
    {
        $data_do_ultimo_ano = Carbon::now()->subYear()->endOfYear()->toDateString();
        $ano_referencia = Carbon::now()->year - 1;

        $funcionarios = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->where('dt_inicio', '<', $data_do_ultimo_ano)
            ->select('pessoas.id as id_pessoa', 'funcionarios.id as id_funcionario', 'funcionarios.dt_inicio as data_de_inicio', 'pessoas.nome_completo')
            ->get();


        foreach ($funcionarios as $funcionario) {
            $data_inicio_periodo_aquisitivo = Carbon::parse($funcionario->data_de_inicio)->copy()->year(Carbon::now()->year - 1)->toDateString();
            $data_fim_periodo_aquisitivo = Carbon::parse($funcionario->data_de_inicio)->copy()->year(Carbon::now()->year)->subDays(1)->toDateString();
            $funcionario->data_inicio_periodo_aquisitivo = $data_inicio_periodo_aquisitivo;
            $funcionario->data_fim_periodo_aquisitivo = $data_fim_periodo_aquisitivo;
            $funcionario->data_inicio_periodo_de_gozo = Carbon::parse($funcionario->data_de_inicio)->copy()->year(Carbon::now()->year)->toDateString();
            $funcionario->data_fim_periodo_de_gozo = Carbon::parse($funcionario->data_de_inicio)->copy()->year(Carbon::now()->year + 1)->subDays(1)->toDateString();
        }

        $ferias = DB::table('ferias')
            ->where('ano_de_referencia', '=', $ano_referencia)
            ->get();

        if ($ferias->isEmpty()) {
            foreach ($funcionarios as $funcionario) {
                DB::table('ferias')
                    ->insert([
                        'ano_de_referencia' => $ano_referencia,
                        'inicio_periodo_aquisitivo' => $funcionario->data_inicio_periodo_aquisitivo,
                        'fim_periodo_aquisitivo' => $funcionario->data_fim_periodo_aquisitivo,
                        'status_pedido_ferias' => 1,
                        'id_funcionario' => $funcionario->id_funcionario,
                        'dt_inicio_periodo_de_licenca' => $funcionario->data_inicio_periodo_de_gozo,
                        'dt_fim_periodo_de_licenca' => $funcionario->data_fim_periodo_de_gozo

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
            ->where('ano_de_referencia', '=', $ano_referente)
            ->where('status_pedido_ferias.id', '!=', 1)
            ->get();

        $anos_possiveis = DB::table('ferias')
            ->select('ano_de_referencia')
            ->groupBy('ano_de_referencia')
            ->get();

        return view('ferias.administrar-ferias', compact('periodo_aquisitivo', 'anos_possiveis'));
    }

    public function autorizarferias($id)
    {

        $periodo_de_ferias = DB::table('ferias')
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
        DB::table('ferias')->where('id', '=', $id)->update([
            'status_pedido_ferias' => 5
        ]);

        return redirect()->back();
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
                'status_pedido_ferias' => 4
            ]);

        return redirect()->route('AdministrarFerias');
    }

}
