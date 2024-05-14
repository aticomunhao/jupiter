<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Str;
use Intervention\Image\Facades\Image;


class PhotoController extends Controller
{
    public function showCaptureForm($ida)
    {


        $associado = DB::table('associado AS ass')
            ->leftJoin('pessoas AS p', 'ass.id_pessoa', '=', 'p.id')
            ->where('ass.id', $ida)
            ->select(
                'ass.nr_associado',
                'ass.id',
                'p.nome_completo',
                'ass.dt_inicio',
                'ass.dt_fim'
            )->first();;
        //    dd($foto_associado);

        return view('/associado/capture-form', compact('associado', 'ida'));
    }

    public function storeCapturedPhoto(Request $request, $ida)
    {
        // Verifica se a requisição contém a foto
        if ($request->has('photo')) {
            // Obtém a foto codificada em base64 do input 'photo'
            $photoData = $request->input('photo');

            // Remove o cabeçalho da string base64 e decodifica a foto
            $fotoConteudo = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photoData));

            // Verifica se a decodificação foi bem-sucedida
            if ($fotoConteudo !== false) {
                // Tenta abrir a imagem usando o Intervention Image
                try {
                    // Abre a imagem a partir dos dados decodificados
                    $image = Image::make($fotoConteudo);

                    // Gera um nome único para o arquivo
                    $nomeArquivo = Str::random(40) . '_photo.jpg'; // Utiliza Str::random() corretamente

                    // Salva a foto no armazenamento público
                    $image->save(public_path('storage/fotos-pessoas/' . $nomeArquivo));

                    // Caminho completo do arquivo para salvar no banco de dados
                    $caminhoArquivo = 'fotos-pessoas/' . $nomeArquivo;

                    // Atualiza o caminho da foto no banco de dados
                    DB::table('associado')->where('id', $ida)->update(['caminho_foto_associado' => $caminhoArquivo]);

                    // Retorna uma resposta de sucesso
                    return redirect()->back()->with('success', 'Foto salva com sucesso.');
                } catch (\Exception $e) {
                    // Retorna uma resposta de erro se ocorrer uma exceção ao abrir a imagem
                    return redirect()->back()->with('error', 'Erro ao abrir a imagem.');
                }
            }
        }

        // Retorna uma resposta de erro se a foto não for fornecida ou houver falha na decodificação
        return redirect()->back()->with('error', 'Erro ao salvar a foto.');
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
