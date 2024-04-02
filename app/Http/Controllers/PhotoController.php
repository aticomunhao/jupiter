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

        $caminho = ('fotos-pessoas/' . $nomeArquivo);

       
        if ($caminhoArquivo) {

            DB::table('user_photos')->insert([
                'caminho_foto' => $caminho
            ]);
    
            return redirect()->back()->with('success', 'Foto salva com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao salvar a foto.');
        }
    }
    
    
}
