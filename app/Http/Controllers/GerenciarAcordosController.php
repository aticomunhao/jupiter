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
            ->where('funcionarios.id', '=', "$idf")->first();

        $acordos = DB::select("select acordos.id,
       acordos.data_inicio,
       acordos.data_fim,
       acordos.observacao,
       tp_acordo.nome,
       acordos.valido,
       acordos.caminho from acordos
        join tp_acordo on tp_acordo.id = acordos.id_tp_acordo
        where acordos.id_funcionario = $idf");


        foreach ($acordos as $acordo) {

            $dataDeHoje = new DateTime();
            $dataFormatada = $dataDeHoje->format('Y-m-d');
            $datadoBancoDeDados = new DateTime($acordo->data_fim);
            $datadoBancoDeDadosFormatada = $datadoBancoDeDados->format('Y-m-d');

            if ($dataFormatada <= $datadoBancoDeDadosFormatada) {
                $acordo->valido = "Sim";
            } else {
                $acordo->valido = "Não";
            }
        }

        return view('acordos.gerenciar-acordos', compact('acordos', 'funcionario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {

        $tipoacordo = DB::table('tp_acordo')
            ->get();

        $funcionario = DB::table("funcionarios")
            ->join('pessoas', 'pessoas.id', '=', 'funcionarios.id_pessoa')
            ->select('funcionarios.id', 'pessoas.nome_completo')
            ->first();


        return view('acordos.incluir-acordo', compact('tipoacordo', 'funcionario'));
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


        if ($request->input('dt_inicio') > $request->input('dt_fim') and $request->input('dt_fim') != null) {
            $caminho = $request->file('ficheiro')->store('public/images');
            app('flasher')->addError('A data inicial é maior que a data final');
            return redirect()->route('indexGerenciarAcordos', ['id' => $idf]);

        } elseif ($request->input('dt_fim') == null) {
            $caminho = $request->file('ficheiro')->store('public/images');
            DB::table('acordos')->insert([
                'id_tp_acordo' => $request->input('tipo_acordo'),
                'data_inicio' => $request->input('dt_inicio'),
                'id_funcionario' => $idf,
                'observacao' => $request->input('observacao'),
                'caminho' => $caminho
            ]);
            app('flasher')->addSuccess('O cadastro do Acordo foi realizado com sucesso.');
            return redirect()->route('indexGerenciarAcordos', ['id' => $idf]);

        } else {
            $caminho = $request->file('ficheiro')->store('public/images');
            DB::table('acordos')->insert([
                'id_tp_acordo' => $request->input('tipo_acordo'),
                'data_inicio' => $request->input('dt_inicio'),
                'data_fim' => $request->input('dt_fim'),
                'id_funcionario' => $idf,
                'observacao' => $request->input('observacao'),
                'caminho' => $caminho
            ]);
            app('flasher')->addSuccess('O cadastro do Acordo foi realizado com sucesso.');
            return redirect()->route('indexGerenciarAcordos', ['id' => $idf]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $acordo = Db::table('acordos')->where('id', $id)->first();


        $funcionario = DB::table('funcionarios')
            ->join('pessoas', 'pessoas.id', '=', 'funcionarios.id_pessoa')
            ->select('pessoas.cpf', 'pessoas.nome_completo', 'funcionarios.id')->first();

        $tipoacordo = DB::table('tp_acordo')->get();

        return view('acordos.editar-acordos', compact('acordo', 'funcionario', 'tipoacordo'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $acordo = Db::table('acordos')->where('id', $id)->first();

        $funcionario = DB::table('funcionarios')
            ->join('pessoas', 'pessoas.id', '=', 'funcionarios.id_pessoa')
            ->select('pessoas.cpf', 'pessoas.nome_completo', 'funcionarios.id')
            ->where('funcionarios.id', $acordo->id_funcionario)
            ->first();


        if ($request->input('dt_inicio') > $request->input('dt_fim') and $request->input('dt_fim') != null) {
            app('flasher')->addError('A data inicial é maior que a data final');
            return redirect()->route('indexGerenciarAcordos', ['id' => $acordo->id_funcionario]);
        } elseif ($request->file('ficheiroNovo') == null) {
            Db::table('acordos')
                ->where('id', $acordo->id)
                ->update([
                    'id_tp_acordo' => $request->input('tipo_acordo'),
                    'data_inicio' => $request->input('dt_inicio'),
                    'data_fim' => $request->input('dt_fim'),
                    'observacao' => $request->input('observacao')
                ]);
            app('flasher')->addWarning('O cadastro do Acordo foi Alterado com Sucesso.');
            return redirect()->route('indexGerenciarAcordos', ['id' => $acordo->id_funcionario]);
        } elseif ($request->file('ficheiroNovo') != null and $request->hasFile('ficheiroNovo')) {
            // Check if the file is present in the request
            $caminho = $request->file('ficheiroNovo')->store('public/images');
            Db::table('acordos')
                ->where('id', $acordo->id)
                ->update([
                    'id_tp_acordo' => $request->input('tipo_acordo'),
                    'data_inicio' => $request->input('dt_inicio'),
                    'data_fim' => $request->input('dt_fim'),
                    'observacao' => $request->input('observacao'),
                    'caminho' => $caminho
                ]);
        };
        app('flasher')->addWarning('O cadastro do Acordo foi Alterado com Sucesso.');
        return redirect()->route('indexGerenciarAcordos', ['id' => $acordo->id_funcionario]);
    }


    public function destroy(string $id)
    {
        $acordo = Db::table('acordos')->where('id', $id)->first();
        Storage::delete($acordo->caminho);
        Db::table('acordos')->where('id', $id)->delete();
        app('flasher')
            ->addWarning('O cadastro do Acordo foi Removido com Sucesso.');
        return redirect()->back();
    }
}
