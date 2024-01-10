<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class GerenciarTipoDesconto extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pesquisa = request('pesquisa');

        if ($pesquisa) {
            $desc = DB::table('tipo_desconto')
                ->where('description', 'ilike', '%' . $pesquisa . '%')
                ->get();
        } else {
            $desc = DB::table('tipo_desconto')->orderBy('description', 'asc')->get();
        }

        return view('/tipopagamento/gerenciar-tp-desconto', compact('desc', 'pesquisa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/tipopagamento/incluir-tp-desconto');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('tipo_desconto')->insert([
            'description' => $request->input('tpdesc'),
            'percDesconto' => $request->input('pecdesc'),
        ]);
        app('flasher')->addSuccess('Tipo de desconto cadastrada com sucesso');
        return redirect()->route('indexTipoDesconto');
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
        $info = DB::table('tipo_desconto')
            ->where('id', $id)
            ->first();

        return view('/tipopagamento/editar-tp-desconto', compact('info'));
    }

    /**
     * Update the specified resource in storage.
     */
    //Request $request, string $id
    public function update(Request $request, string $id)
    {
        DB::table('tipo_desconto')
            ->where('id', $id)
            ->update([
                'description' => $request->input('edittpdesc'),
                'percDesconto' => $request->input('editpecdesc'),
            ]);

        app('flasher')->addwarning('Tipo de desconto atualizada com sucesso');
        return redirect()->route('indexTipoDesconto');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $dest = DB::table('tipo_desconto')
            ->where('id', $id)
            ->delete();
        app('flasher')->addError('Tipo de desconto excluído com sucesso');
        return redirect()->route('indexTipoDesconto');
    }
}
