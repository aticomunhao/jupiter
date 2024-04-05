<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class PhotoController extends Controller
{
    public function showCaptureForm($ida)
    {
        //dd($ida);
        return view('/associado/capture-form');
    }
    public function storeCapturedPhoto(Request $request)
    {
        $photoData = $request->input('photo');


        $fotoConteudo = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photoData));

        //  dd($fotoConteudo);


        $nomeArquivo = Hash::make(time() . '_photo') . '.jpg';

        $caminhoArquivo = Storage::disk('public')->put('fotos-pessoas/' . $nomeArquivo, $fotoConteudo);

        $caminho = ('public/fotos-pessoas/' . $nomeArquivo);


        if ($caminhoArquivo) {

            DB::table('user_photos')->insert([
                'caminho_foto' => $caminho
            ]);



            return redirect()->back()->with('success', 'Foto salva com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao salvar a foto.');
        }
    }
    public function visualizarfoto()
    {
     
        $ultimoId = DB::table('user_photos')
        ->orderBy('id', 'desc')
        ->first()->id;
       // dd($ultimoId);

        
        $caminhodocumento = DB::table('user_photos AS us')
        ->where('us.id', $ultimoId)
        ->select(['us.caminho_foto'])
        ->first();

      //  dd($caminho);

    if ($caminhodocumento) {
        $caminho = $caminhodocumento->caminho_foto;

        //dd($caminho);

        if (Storage::exists($caminho)) {
            return response()->file(storage_path('app/' . $caminho));
        } else {
            return abort(404);
        }
    } else {
        return abort(404);
    }
}
}