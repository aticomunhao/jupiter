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
            $desc = DB::table('tipo_desconto')
                ->orderBy('dt_final', 'desc')
                ->get();
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
        $id_increment = DB::table('tipo_desconto') // Pega o ultimo id lancado no banco
            ->get()
            ->last();

        $ss = DB::table('tipo_desconto')->count(); //conta o numero de linhas da tabela


         if (round($ss) == 0) { //

             $idd = 1;
         } else {
            $idd = $id_increment->id_tipo + 1;

         }

        DB::table('tipo_desconto')->insert([
            'description' => $request->input('tpdesc'),
            'percDesconto' => $request->input('pecdesc'),
            'dt_inicio' => $request->input('dtdesc'),
            'id_tipo' => $idd,
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
    public function update(Request $request, string $id)
    {
        DB::table('tipo_desconto')
            ->where('id', $id)
            ->update([
                'description' => $request->input('edittpdesc'),
                'percDesconto' => $request->input('editpecdesc'),
                'dt_inicio' => $request->input('dtdesc'),
            ]);

        app('flasher')->addwarning('Tipo de desconto modificada com sucesso');
        return redirect()->route('indexTipoDesconto');
    }


    public function renew(string $id)
    {
        $inf = DB::table('tipo_desconto')
            ->where('id', $id)
            ->first();

        return view('/tipopagamento/atualizar-tp-desconto', compact('inf'));
    }



    public function modify(Request $request, string $id)
    {

        $lst = DB::table('tipo_desconto')
        ->where('id', $id)->first();
        DB::table('tipo_desconto')
            ->insert([
                'description' => $request->input('edittpdesc'),
                'percDesconto' => $request->input('editpecdesc'),
                'dt_inicio' => $request->input('dtdesc'),
                'id_tipo' => $lst->id_tipo,
            ]);

            DB::table('tipo_desconto')
            ->where('id', $id)
            ->update([
                'dt_final' => $request->input('dtdesc'),
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
