<?php

namespace App\Http\Controllers;

use App\Models\pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use File;
use DateTime;
use Illuminate\Support\Facades\Storage;

class GerenciarAcordosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {
        $funcionario = DB::table('funcionarios')
            ->join('pessoas', 'pessoas.id', '=', 'funcionarios.id_pessoa')
            ->select('funcionarios.id', 'pessoas.nome_completo')
            ->where('funcionarios.id', '=', $idf)
            ->first();

        $acordos = DB::table('acordo')
            ->join('tp_acordo', 'tp_acordo.id', '=', 'acordo.tp_acordo')
            ->leftJoin('tp_demissao', 'tp_demissao.id', 'acordo.id_tp_demissao')
            ->select(
                'acordo.id',
                'acordo.matricula',
                'acordo.dt_inicio',
                'acordo.dt_fim',
                'tp_acordo.nome',
                'acordo.id_tp_demissao',
                'acordo.id_funcionario',
                'acordo.admissao',
                'acordo.caminho',
                'tp_demissao.motivo'
            )
            ->where('acordo.id_funcionario', $idf)
            ->get();

        foreach ($acordos as $acordo) {
            $dataDeHoje = new DateTime();
            $dataFormatada = $dataDeHoje->format('Y-m-d');
            $datadoBancoDeDados = new DateTime($acordo->dt_fim);
            $datadoBancoDeDadosFormatada = $datadoBancoDeDados->format('Y-m-d');
            $acordo->valido = ($dataFormatada <= $datadoBancoDeDadosFormatada) ? "Sim" : "Não";
        }

        return view('acordos.gerenciar-acordos', compact('acordos', 'funcionario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {
        $tipoacordo = DB::table('tp_acordo')->get();

        $funcionario = DB::table("funcionarios")
            ->join('pessoas', 'pessoas.id', '=', 'funcionarios.id_pessoa')
            ->select('funcionarios.id', 'pessoas.nome_completo')
            ->where('funcionarios.id', $idf)
            ->first();

        return view('acordos.incluir-acordo', compact('tipoacordo', 'funcionario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idf)
    {
        $funcionario = DB::table('funcionarios')
            ->leftJoin('pessoas', 'funcionarios.id_pessoa', '=', 'pessoas.id')
            ->leftJoin('acordo', 'funcionarios.id', 'acordo.id_funcionario')
            ->select('pessoas.nome_completo', 'pessoas.cpf', 'funcionarios.id', 'acordo.matricula')
            ->where('funcionarios.id', $idf)
            ->first();


        //dd($funcionario, $idf);

        if ($request->input('dt_inicio') > $request->input('dt_fim') && $request->input('dt_fim') != null) {
            //$caminho = $this->storeFile($request);
            app('flasher')->addError('A data inicial é maior que a data final');
            return redirect()->route('indexGerenciarAcordos', ['id' => $idf]);
        } elseif ($funcionario && $funcionario->matricula == $request->input('matricula')) {
            $caminho = $this->storeFile($request ?? '');;
            $data = [
                'tp_acordo' => $request->input('tipo_acordo'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'id_funcionario' => $idf,
                'caminho' => $caminho,
                'matricula' => $request->input('matricula'),
                'admissao' => '0',
            ];

            DB::table('acordo')->insert($data);
            app('flasher')->addSuccess('O novo cadastro do Acordo foi realizado com sucesso.');
            return redirect()->route('indexGerenciarAcordos', ['id' => $idf]);
        } else {
            $caminho = $this->storeFile($request ?? '');;
            $data = [
                'tp_acordo' => $request->input('tipo_acordo'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'id_funcionario' => $idf,
                'caminho' => $caminho,
                'matricula' => $request->input('matricula'),
                'admissao' => '1',
            ];

            DB::table('acordo')->insert($data);
            app('flasher')->addSuccess('O cadastro do Acordo foi realizado com sucesso.');
            return redirect()->route('indexGerenciarAcordos', ['id' => $idf]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $acordo = DB::table('acordo')->where('id', $id)->first();
        $funcionario = $this->getFuncionarioData($acordo->id_funcionario);
        $tipoacordo = DB::table('tp_acordo')->get();

        return view('acordos.editar-acordos', compact('acordo', 'funcionario', 'tipoacordo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $acordo = DB::table('acordo')->where('id', $id)->first();
        $funcionario = $this->getFuncionarioData($acordo->id_funcionario);

        if ($request->input('dt_inicio') > $request->input('dt_fim') and $request->input('dt_fim') != null) {
            app('flasher')->addError('A data inicial é maior que a data final');
            return redirect()->route('indexGerenciarAcordos', ['id' => $acordo->id_funcionario]);
        } elseif ($request->file('ficheiroNovo') == null) {
            $this->updateAcordoWithoutFile($acordo, $request);
        } elseif ($request->hasFile('ficheiroNovo')) {
            $this->updateAcordoWithFile($acordo, $request);
        } else {
            app('flasher')->addWarning('O cadastro do Acordo foi Alterado com Sucesso.');
        }

        return redirect()->route('indexGerenciarAcordos', ['id' => $acordo->id_funcionario]);
    }

    private function updateAcordoWithFile($acordo, Request $request)
    {
        $nomeArquivo = $request->file('ficheiroNovo')->getClientOriginalName();
        $novoCaminho = $request->file('ficheiroNovo')->storeAs('public/images', $nomeArquivo);

        if ($novoCaminho) {
            Storage::delete($acordo->caminho); // Remove o arquivo antigo

            DB::table('acordo')
                ->where('id', $acordo->id)
                ->update([
                    'tp_acordo' => $request->input('tipo_acordo'),
                    'dt_inicio' => $request->input('dt_inicio'),
                    'dt_fim' => $request->input('dt_fim'),
                    'caminho' => 'storage/images/' . $nomeArquivo,
                    'matricula' => $request->input('matricula'),
                ]);
        }
    }

    public function destroy(string $id)
    {
        $acordo = DB::table('acordo')->where('id', $id)->first();
        Storage::delete($acordo->caminho);
        DB::table('acordo')->where('id', $id)->delete();

        app('flasher')->addWarning('O cadastro do Acordo foi Removido com Sucesso.');
        return redirect()->back();
    }

    // Métodos Auxiliares

    private function storeFile(Request $request)
    {
        if ($request->hasFile('ficheiro')) {
            $caminho = $request->file('ficheiro')->storeAs('public/images', $request->file('ficheiro')->getClientOriginalName());
            return 'storage/images/' . $request->file('ficheiro')->getClientOriginalName();
        }
        return '';
    }

    private function updateAcordoWithoutFile($acordo, Request $request)
    {
        DB::table('acordo')
            ->where('id', $acordo->id)
            ->update([
                'tp_acordo' => $request->input('tipo_acordo'),
                'dt_inicio' => $request->input('dt_inicio'),
                'dt_fim' => $request->input('dt_fim'),
                'matricula' => $request->input('matricula'),
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
