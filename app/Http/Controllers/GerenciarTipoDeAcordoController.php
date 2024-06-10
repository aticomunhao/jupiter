<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GerenciarTipoDeAcordoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos_de_acordo = DB::table('tp_acordo')->get();

        return view('tipos_de_acordo.gerenciar-tipos-de-acordo', compact('tipos_de_acordo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipos_de_acordo\incluir-tipo-de-acordo');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $nome = $request->input('nome');

            DB::table('tp_acordo')->insert(['nome' => $nome]);
            app('flasher')->addSuccess("Adicionado com Sucesso");
        } catch (Exception $exception) {
            app('flasher')->addError('Erro: ' . $exception->getCode() . " favor contatar o administrador.");
        } finally {
            return redirect()->route('index.tipos-de-acordo');
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
        $tipo_de_acordo =  DB::table('tp_acordo')->where('id', '=', $id)->first();

        return view('tipos_de_acordo.editar-tipo-de-acordo', compact('tipo_de_acordo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $nome = $request->input('nome');
            DB::table('tp_acordo')->where('id', $id)->update(['nome' => $nome]);
            app('flasher')->addSuccess('Editado com Sucesso');
        } catch (Exception $exception) {
            app('flasher')->addError('Erro: ' . $exception->getCode() . " favor contatar o administrador.");
        } finally {
            return redirect()->route('index.tipos-de-acordo');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::table('tp_acordo')->where('id', $id)->delete();
            app('flasher')->addWarning('Deletado com Sucesso');
        } catch (Exception $exception) {
            app('flasher')->addError('Erro: ' . $exception->getCode() . " favor contatar o administrador.");
        } finally {
            return redirect()->route('index.tipos-de-acordo');
        }
    }
}
