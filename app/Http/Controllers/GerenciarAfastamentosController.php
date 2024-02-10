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
            ->select('afastamento.id_tp_afastamento', 'tp_afastamento.nome AS nome_afa',  'p.nome_completo AS nome', 'afastamento.dt_inicio', 'tp_afastamento.limite', 'afastamento.id', 'afastamento.caminho', 'afastamento.dt_fim')
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
        $funcionario = DB::table('funcionarios')
            ->join('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->select('pessoas.nome_completo', 'pessoas.cpf', 'funcionarios.id')
            ->where('funcionarios.id', $idf)
            ->first();

        if ($request->input('dt_inicio') > $request->input('dt_fim') && $request->input('dt_fim') != null) {
            $caminho = $this->storeFile($request);
            app('flasher')->addError('A data inicial é maior que a data final');
            return redirect()->route('indexGerenciarAfastamentos', ['idf' => $idf]);
        } else {
            $caminho = $this->storeFile($request);
            $data = [
                'id_tp_afastamento' => $request->input('tipo_afastamento'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'id_funcionario' => $idf,
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
    public function edit(string $id)
    {
        $afastamentos = DB::table('afastamento')->where('id', $id)->first();
        $funcionario = $this->getFuncionarioData($afastamentos->id_funcionario);
        $tipoafastamentos = DB::table('tp_afastamento')->get();

        return view('afastamentos.editar-afastamentos', compact('afastamentos', 'funcionario', 'tipoafastamentos'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $afastamentos = DB::table('afastamento')->where('id', $id)->first();
        Storage::delete($afastamentos->caminho);
        DB::table('afastamento')->where('id', $id)->delete();

        app('flasher')->addWarning('O cadastro do afastamento foi removido com sucesso.');
        return redirect()->back();
    }


    // Métodos Auxiliares

    private function storeFile(Request $request)
    {
        $caminho = $request->file('ficheiro')->storeAs('public/images', $request->file('ficheiro')->getClientOriginalName());
        return 'storage/images/' . $request->file('ficheiro')->getClientOriginalName();
    }

    private function updateAfastamentosWithoutFile($afastamento, Request $request)
    {

        DB::table('afastamento')->where('id', $afastamento->id)->update([
            'id_tp_afastamento' => $request->input('tipo_afastamento'),
            'dt_inicio' => $request->input('dt_inicio'),
            'dt_fim' => $request->input('dt_fim'),
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
