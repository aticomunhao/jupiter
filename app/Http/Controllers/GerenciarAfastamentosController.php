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
            ->select('afastamento.id_tp_afastamento', 'tp_afastamento.nome AS nome_afa',  'p.nome_completo AS nome', 'afastamento.dt_inicio', 'tp_afastamento.limite', 'afastamento.id', 'afastamento.caminho', 'afastamento.dt_fim', 'afastamento.justificado')
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

       $justificado=isset($request->justificado) ? true : false ;



        if ($request->input('dt_inicio') >= $request->input('dt_fim') && $request->input('dt_fim') != null) {
            $caminho = $this->storeFile($request);
            app('flasher')->addError('A data inicial é maior ou igual a data final');
            return redirect()->route('indexGerenciarAfastamentos', ['idf' => $idf]);
        } else {
            $caminho = $this->storeFile($request);
            $data = [
                'qtd_dias' => Carbon::parse($request->input('dt_inicio'))->diffInDays(Carbon::parse($request->input('dt_fim'))),
                'id_tp_afastamento' => $request->input('tipo_afastamento'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'id_funcionario' => $idf,
                'justificado'=> $justificado,
                'observacao' => $request->input('observacao'),
                'caminho' => $caminho
            ];


            DB::table('afastamento')->insert($data);
            app('flasher')->addSuccess('O cadastro do afastamentos foi realizado com sucesso.');
            return redirect()->route('indexGerenciarAfastamentos', ['idf' => $idf]);
        }
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
    public function edit(string $id, Request $request)
    {
        $afastamentos = DB::table('afastamento')->where('id', $id)->first();


        $afastamento_com_tipo = DB::table('afastamento')
            ->join('tp_afastamento', 'afastamento.id_tp_afastamento', '=', 'tp_afastamento.id')
            ->where('afastamento.id', $id)
            ->select('afastamento.*', 'tp_afastamento.nome as nome_tp_afastamento')
            ->first();



        $funcionario = $this->getFuncionarioData($afastamentos->id_funcionario);
        $tipoafastamentos = DB::table('tp_afastamento')->get();

        return view('afastamentos.editar-afastamentos', compact('afastamentos', 'afastamento_com_tipo', 'funcionario', 'tipoafastamentos'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $afastamento = DB::table('afastamento')->where('id', $id)->first();




        if ($request->input('dt_inicio') > $request->input('dt_fim') and $request->input('dt_fim') != null) {
            app('flasher')->addError('A data inicial é maior que a data final');
            return redirect()->route('indexGerenciarAfastamentos', ['id' => $afastamento->id_funcionario]);
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
    public function destroy(string $id)
    {
        $afastamento = DB::table('afastamento')->where('id', $id)->first();
        if (!$afastamento) {
            app('flasher')->addError('Registro de afastamento não encontrado.');
            return redirect()->back();
        }

        // Excluir o arquivo associado, se existir
        if ($afastamento->caminho && Storage::exists($afastamento->caminho)) {
            Storage::delete($afastamento->caminho);
        }

        // Excluir o registro do afastamento
        DB::table('afastamento')->where('id', $id)->delete();

        app('flasher')->addWarning('O cadastro do afastamento foi removido com sucesso.');
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
        $justificado=isset($request->justificado) ? true : false ;

        DB::table('afastamento')
        ->where('id', $afastamento->id)
        ->update([
            'qtd_dias' => Carbon::parse($request->input('dt_inicio'))->diffInDays(Carbon::parse($request->input('dt_fim'))),
            'id_tp_afastamento' => $request->input('tipo_afastamento'),
            'dt_inicio' => $request->input('dt_inicio'),
            'dt_fim' => $request->input('dt_fim'),
            'justificado'=> $justificado,
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
}
