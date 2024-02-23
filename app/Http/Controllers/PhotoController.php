<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{
    public function showCaptureForm()
    {
        return view('capture-form');
    }
public function storeCapturedPhoto(Request $request)
{
    $user = auth()->user();

    if ($user && $user->id) {
        $photoData = $request->input('photo');

        // Salva a foto diretamente no banco de dados
        DB::table('user_photos')->insert([
            'user_id' => $user->id,
            'photo' => $photoData,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('capture.form')->with('success', 'Photo captured and saved successfully!');
    } else {
        return redirect()->route('login')->with('error', 'You need to log in to capture photos.');
    }
}

    
}
