<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Echo_;
use Illuminate\Support\Facades\Storage;

class GerenciarAfastamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {
        $funcionario = DB::table('funcionarios')
            ->leftjoin('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->where('funcionarios.id', '=', $idf)
            ->select('funcionarios.id AS funcionario_id', 'pessoas.nome_completo', 'pessoas.id AS pessoas_id')
            ->first();


        $afastamentos = DB::table('afastamento')
            ->leftJoin('funcionarios AS f', 'afastamento.id_funcionario', 'f.id')
            ->leftJoin('pessoas AS p', 'f.id_pessoa', 'p.id')
            ->leftJoin('tp_afastamento', 'afastamento.id_tp_afastamento', 'tp_afastamento.id')
            ->select('afastamento.id_tp_afastamento', 'tp_afastamento.nome AS nome_afa', 'p.nome_completo AS nome', 'afastamento.dt_inicio AS inicio', 'tp_afastamento.limite', 'afastamento.id', 'afastamento.caminho', 'afastamento.dt_fim', 'afastamento.justificado', 'f.dt_inicio')
            ->where('afastamento.id_funcionario', '=', $idf)
            ->get();



        return view('afastamentos.gerenciar-afastamentos', compact('funcionario', 'afastamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {
        $tipoafastamento = DB::table('tp_afastamento AS afa')
            ->select('afa.id', 'afa.nome', 'afa.limite')
            ->get();


        $funcionario = DB::table('funcionarios')
            ->leftjoin('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->where('funcionarios.id', '=', $idf)
            ->select('funcionarios.id as funcionario_id', 'pessoas.nome_completo', 'pessoas.id as pessoas_id')
            ->first();

        return view('afastamentos.incluir-afastamento', compact('funcionario', 'tipoafastamento'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idf)
    {
        // Busca da data de início do funcionário
        $afastamentos = DB::table('funcionarios AS f')
            ->leftJoin('afastamento', 'afastamento.id_funcionario', 'f.id')
            ->where('f.id', $idf)
            ->value('f.dt_inicio');

        // Busca o último afastamento do funcionário com dt_fim == null (afastamento "em aberto")
        $afastamentoAberto = DB::table('acordo')
            ->where('id_funcionario', '=', $idf)
            ->where('tp_acordo', '=', $request->input('tipo_afastamento')) // Verifica o tipo de afastamento
            ->whereNull('dt_fim') // Verifica se a dt_fim está null
            ->orderByDesc('dt_inicio') // Ordena para pegar o mais recente
            ->first();

        // Conversão de datas utilizando Carbon
        $dataInicioFuncionario = Carbon::parse($afastamentos);
        $dataInicioRequisicao = Carbon::parse($request->input('dt_inicio'));

        $justificado = $request->has('justificado'); // Simplificado

        // Verifica se a data de início da requisição é anterior à do funcionário
        $teste = $dataInicioRequisicao->lt($dataInicioFuncionario);

        // Verifica se a data inicial é maior ou igual à data final
        if ($dataInicioRequisicao->gte(Carbon::parse($request->input('dt_fim')))) {
            app('flasher')->addError('A data inicial é maior ou igual à data final');
            return redirect()->back()->withInput();
        } elseif ($teste) {
            app('flasher')->addError('O funcionário não pertencia à comunhão nessa data inicial');
            return back()->withInput();
        } else {
            // Salvamento do arquivo
            $caminho = $this->storeFile($request);

            // Dados para inserção na tabela afastamento
            $dataAfastamento = [
                'qtd_dias' => Carbon::parse($request->input('dt_inicio'))->diffInDays(Carbon::parse($request->input('dt_fim'))),
                'id_tp_afastamento' => $request->input('tipo_afastamento'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'id_funcionario' => $idf,
                'justificado' => $justificado,
                'observacao' => $request->input('observacao'),
                'caminho' => $caminho,
            ];

            // Insere o novo afastamento
            $idAfastamento = DB::table('afastamento')->insertGetId($dataAfastamento);

            // Verifica se a dt_fim está presente e se o tipo de afastamento é 16 antes de inserir na tabela acordo
            if (!is_null($request->input('dt_fim')) && in_array($request->input('tipo_afastamento'), [16])) {
                $novoAcordo = [
                    'matricula' => $afastamentoAberto->matricula,
                    'tp_acordo' => $afastamentoAberto->tp_acordo,
                    'id_funcionario' => $idf,
                    'dt_inicio' => $request->input('dt_inicio'),
                    'dt_fim' => $request->input('dt_fim'),
                    'admissao' => 'false',
                    'id_afastamento' => $idAfastamento, // Associar com o afastamento recém-criado
                ];

                DB::table('acordo')->insert($novoAcordo);

                // Verifica se a dt_fim está presente e se o tipo de afastamento é 17 antes de inserir na tabela acordo
            } elseif (!is_null($request->input('dt_fim')) && in_array($request->input('tipo_afastamento'), [17])) {

                // Verifica a duração do afastamento atual
                $dtInicio = Carbon::parse($request->input('dt_inicio'));
                $dtFim = Carbon::parse($request->input('dt_fim'));
                $anoAtual = $dtInicio->year;
                $diferencaMesesAtual = $dtInicio->diffInMonths($dtFim);

                // Soma a duração de afastamentos anteriores do tipo 17 dentro do mesmo ano
                $somaAfastamentos = DB::table('afastamento')
                    ->where('id_funcionario', $idf)
                    ->where('id_tp_afastamento', 17)
                    ->whereNotNull('dt_fim')
                    ->whereYear('dt_inicio', $anoAtual) // Filtra pelo mesmo ano
                    ->select(DB::raw('SUM(EXTRACT(MONTH FROM AGE(dt_fim, dt_inicio))) as meses'))
                    ->first();

                $mesesAnteriores = $somaAfastamentos ? $somaAfastamentos->meses : 0;
                $somaTotalMeses = $mesesAnteriores + $diferencaMesesAtual;

                if ($diferencaMesesAtual >= 6) {
                    // Insere o novo afastamento se o afastamento atual sozinho exceder 6 meses
                    $novoAcordo = [
                        'matricula' => $request->input('matricula'),
                        'tp_acordo' => $request->input('tipo_afastamento'),
                        'id_funcionario' => $idf,
                        'dt_inicio' => $request->input('dt_inicio'),
                        'dt_fim' => $request->input('dt_fim'),
                        'admissao' => 'false',
                        'id_afastamento' => $idAfastamento,
                    ];

                    DB::table('acordo')->insert($novoAcordo);

                } elseif ($somaTotalMeses >= 6) {
                    // Insere o novo afastamento se a soma dos afastamentos anteriores com o atual exceder 6 meses
                    $novoAcordo = [
                        'matricula' => $request->input('matricula'),
                        'tp_acordo' => $request->input('tipo_afastamento'),
                        'id_funcionario' => $idf,
                        'dt_inicio' => $request->input('dt_inicio'),
                        'dt_fim' => $request->input('dt_fim'),
                        'admissao' => 'false',
                        'id_afastamento' => $idAfastamento,
                    ];

                    DB::table('acordo')->insert($novoAcordo);
                }
            }

            app('flasher')->addSuccess('O cadastro do afastamento foi realizado com sucesso.');
            return redirect()->route('indexGerenciarAfastamentos', ['idf' => $idf]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $idf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idf, Request $request)
    {
        $afastamentos = DB::table('afastamento')->where('id', $idf)->first();


        $afastamento_com_tipo = DB::table('afastamento')
            ->join('tp_afastamento', 'afastamento.id_tp_afastamento', '=', 'tp_afastamento.id')
            ->where('afastamento.id', $idf)
            ->select('afastamento.*', 'tp_afastamento.nome as nome_tp_afastamento')
            ->first();



        $funcionario = $this->getFuncionarioData($afastamentos->id_funcionario);
        $tipoafastamentos = DB::table('tp_afastamento')->get();

        return view('afastamentos.editar-afastamentos', compact('afastamentos', 'afastamento_com_tipo', 'funcionario', 'tipoafastamentos'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idf)
    {

        $afastamento = DB::table('afastamento')->where('id', $idf)->first();

        $afastamentos = DB::table('funcionarios AS f')
            ->leftJoin('afastamento', 'afastamento.id_funcionario', 'f.id')
            //->select('f.dt_inicio')
            ->where('afastamento.id', $idf)
            ->value('f.dt_inicio');

        $bola = date(strtotime($afastamentos));
        $canhao = $request->input('dt_inicio');
        $fogo = date(strtotime($canhao));

        $teste = ($fogo < $bola);
        //dd($teste, $bola, $fogo);


        if ($request->input('dt_inicio') >= $request->input('dt_fim') and $request->input('dt_fim')) {
            app('flasher')->addError('A data inicial precisa ser anterior a data final');
            return redirect()->back()->withInput();
        } elseif ($teste) {
            app('flasher')->addError('O funcionário não pertencia a comunhão nessa data inicial');
            return redirect()->back()->withInput();
        } elseif ($request->file('ficheiroNovo') == null) {
            $this->updateAfastamentosWithoutFile($afastamento, $request);
        } elseif ($request->hasFile('ficheiroNovo')) {
            $this->updateAfastamentosWithFile($afastamento, $request);
        }



        app('flasher')->addWarning('O cadastro do afastamento foi alterado com sucesso.');
        return redirect()->route('indexGerenciarAfastamentos', ['idf' => $afastamento->id_funcionario]);
    }

    public function updateAfastamentosWithFile($afastamento, Request $request)
    {
        $nomeArquivo = $request->file('ficheiroNovo')->getClientOriginalName();
        $nomeUnico = uniqid('', true);
        $extensao = $request->file('ficheiroNovo')->getClientOriginalExtension();
        $novoCaminho = $request->file('ficheiroNovo')->storeAs('public/images', $nomeUnico . '.' . $extensao);

        // Verifica se o afastamento é justificado
        $justificado = isset($request->justificado) ? true : false;

        if ($novoCaminho) {
            // Remove o arquivo antigo
            if ($afastamento->caminho && Storage::exists($afastamento->caminho)) {
                Storage::delete($afastamento->caminho);
            }
            DB::table('afastamento')
                ->where('id', $afastamento->id)
                ->update([
                    'qtd_dias' => Carbon::parse($request->input('dt_inicio'))->diffInDays(Carbon::parse($request->input('dt_fim'))),
                    'id_tp_afastamento' => $request->input('tipo_afastamento'),
                    'dt_inicio' => $request->input('dt_inicio'),
                    'dt_fim' => $request->input('dt_fim'),
                    'observacao' => $request->input('observacao'),
                    'justificado' => $justificado,
                    'caminho' => 'storage/images/' . $nomeUnico . '.' . $extensao
                ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idf)
    {
        $afastamento = DB::table('afastamento')->where('id', $idf)->first();
        if (!$afastamento) {
            app('flasher')->addError('Registro de afastamento não encontrado.');
            return redirect()->back();
        }

        // Excluir o arquivo associado, se existir
        if ($afastamento->caminho && Storage::exists($afastamento->caminho)) {
            Storage::delete($afastamento->caminho);
        }

        // Excluir o registro do afastamento
        DB::table('afastamento')->where('id', $idf)->delete();

        app('flasher')->addSuccess('O cadastro do afastamento foi removido com sucesso.');
        return redirect()->back();
    }



    // Métodos Auxiliares

    private function storeFile(Request $request)
    {
        if ($request->hasFile('ficheiro')) {
            $file = $request->file('ficheiro');
            $nomeUnico = uniqid('', true);
            $extensao = $file->getClientOriginalExtension();
            $caminho = $file->storeAs('public/images', $nomeUnico . '.' . $extensao);

            return 'storage/images/' . $nomeUnico . '.' . $extensao;
        } else {
            return null;
        }
    }



    private function updateAfastamentosWithoutFile($afastamento, Request $request)
    {
        $justificado = isset($request->justificado) ? true : false;


        DB::table('afastamento')
            ->where('id', $afastamento->id)
            ->update([
                'qtd_dias' => Carbon::parse($request->input('dt_inicio'))->diffInDays(Carbon::parse($request->input('dt_fim'))),
                'id_tp_afastamento' => $request->input('tipo_afastamento'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'justificado' => $justificado,
                'observacao' => $request->input('observacao')
            ]);
    }


    private function getFuncionarioData($funcionarioId)
    {
        return DB::table('funcionarios')
            ->join('pessoas', 'pessoas.id', '=', 'funcionarios.id_pessoa')
            ->select('pessoas.cpf', 'pessoas.nome_completo', 'funcionarios.id')
            ->where('funcionarios.id', $funcionarioId)
            ->first();
    }

    public function getComplemento($id)
    {
        // Verifica se o ID é 16 (suspensão de contrato)
        if ($id == 16) {
            $complementos = DB::table('complemento_afastamento')
                ->where('referencia', $id)
                ->select('id', 'complemento')
                ->get();

            return response()->json($complementos);
        }

        if ($id == 17) {
            $complementos = DB::table('complemento_afastamento')
                ->where('referencia', $id)
                ->select('id', 'referencia', 'complemento')
                ->get();

            return response()->json($complementos);
        }

        return response()->json([]);
    }

}
