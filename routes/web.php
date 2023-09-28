<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/gerenciar-funcionario', [App\Http\Controllers\GerenciarFuncionarioController::class, 'index'])->name('gerenciar');
Route::get('/informar-dados', [App\Http\Controllers\GerenciarFuncionarioController::class, 'create']);
Route::any('/incluir-funcionario', [App\Http\Controllers\GerenciarFuncionarioController::class, 'store']);
Route::get('/editar-funcionario/{id}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'edit']);

Route::post('/atualizar-funcionario/{idp}{idf}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'update']);

//Route::post('/editar-funcionario/{id}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'index'])->name('editar-funcionario.index');
Route::get('/gerenciar-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'index'])->name('gerenciar-voluntario');
Route::get('/incluir-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'store']);

Route::get('/gerenciar-dados-bancarios', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'index']);


/*Rotas dos Dependentes */
Route::get('/gerenciar-dependentes/{id}', [App\Http\Controllers\GerenciarDependentesController::class, 'index'])->name('Potato');
Route::get('/incluir-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'create']);
Route::any('/armazenar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'store']);
Route::any('/deletar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'destroy']);
Route::any('/editar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'edit']);
Route::any('/atualizar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'update']);

/** Rotas dos Certificados */
Route::get(
    '/gerenciar-certificados/{id}',
    [\App\Http\Controllers\GerenciarCertificadosController::class, 'index']
);

Route::get(
    '/incluir-certificados/{id}',
    [\App\Http\Controllers\GerenciarCertificadosController::class, 'create']
);

/**Rota para Entidades Escolares   */
Route::get('/gerenciar-entidades-de-ensino', [App\Http\Controllers\GerenciarEntidadesController::class, 'index'])->name('batata');
Route::get('/incluir-entidades-ensino', [App\Http\Controllers\GerenciarEntidadesController::class, 'create']);
Route::any('/armazenar-entidade',[App\Http\Controllers\GerenciarEntidadesController::class, 'store']);
Route::any('/excluir-entidade/{id}',[App\Http\Controllers\GerenciarEntidadesController::class, 'destroy']);
Route::any('/editar-entidade/{id}',[App\Http\Controllers\GerenciarEntidadesController::class, 'edit']);
Route::any('/atualizar-entidade-ensino/{id}',[App\Http\Controllers\GerenciarEntidadesController::class, 'update']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
