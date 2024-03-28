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

         $nomeArquivo = Hash::make($photoData);


         $caminhoArquivo = $photoData->storeAs('public/fotos-pessoas', $photoData);

         DB::table('user_photos')->insert([
            'caminho_foto'=>$caminhoArquivo]);

         
        
}

    
}
