<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use DateTime;


class GerenciarAcordosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idf)
    {
        $funcionario = DB::select("select
                            f.id,
                            p.nome_completo
                            from funcionarios f
                            left join pessoas p on f.id_pessoa = p.id
                            where f.id = $idf");
        $acordos = DB::select("select acordos.id, acordos.data_inicio, acordos.data_fim, acordos.observacao, tp_acordo.nome,acordos.valido, acordos.caminho from acordos
        join tp_acordo on tp_acordo.id = acordos.id_tp_acordo
        where acordos.id_funcionario = $idf");


        foreach ($acordos as $acordo) {

            $dataDeHoje = new DateTime('now');
            $dataFormatada = $dataDeHoje->format('Y-m-d');
            $datadoBancoDeDados = new DateTime($acordo->data_fim);
            $datadoBancoDeDadosFormatada = $datadoBancoDeDados->format('Y-m-d');


            if ($dataFormatada <= $datadoBancoDeDadosFormatada) {
                $acordo->valido = "Sim";
            }else{
                $acordo->valido = "Não";
            }
        }

        return view('acordos.gerenciar-acordos', compact('acordos','funcionario'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idf)
    {
        $funcionario = DB::select("select
        f.id,
        p.nome_completo
        from funcionarios f
        left join pessoas p on f.id_pessoa = p.id
        where f.id = $idf");
        $tipoacordo = DB::select('select * from tp_acordo');

        


        return view('acordos.incluir-acordo',compact('tipoacordo','funcionario'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
