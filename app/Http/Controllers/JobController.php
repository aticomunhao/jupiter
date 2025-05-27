<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportarAssociadosJob;
use Illuminate\Support\Facades\Artisan;

class JobController extends Controller
{
    public function executar(Request $request)
    {
        // Executa o Job diretamente, sem passar pela fila
        (new ImportarAssociadosJob())->handle();

        return back()->with('status', 'Job executado diretamente com sucesso!');
    }
}
