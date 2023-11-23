<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;





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
Route::get('/editar-funcionario/{idf}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'edit']);
Route::get('/excluir-funcionario/{idf}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'delete']);
Route::get('/pessoa-funcionario/{idf}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'delete']);

Route::post('/atualizar-funcionario/{idp}/{idf}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'update']);

//Route::post('/editar-funcionario/{id}', [App\Http\Controllers\GerenciarFuncionarioController::class, 'index'])->name('editar-funcionario.index');
Route::get('/gerenciar-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'index'])->name('gerenciar-voluntario');
Route::get('/incluir-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'store']);

Route::get('/gerenciar-dados-bancarios/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'index'])->name('DadoBanc');
Route::get('/incluir-dados-bancarios/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'create']);
Route::get('/armazenar-dados-bancarios/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class,'store']);

Route::get('/deletar-dado-bancario/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class,'destroy']);




Route::get('/gerenciar-setor', [App\Http\Controllers\GerenciarSetoresController::class, 'index']);
Route::get('/pesquisar-setor', [App\Http\Controllers\GerenciarSetoresController::class, 'index'])->name('pesquisar');
Route::get('/incluir-setor', [App\Http\Controllers\GerenciarSetoresController::class, 'create']);
Route::any('/incluir-setores', [App\Http\Controllers\GerenciarSetoresController::class, 'insert']);
Route::get('/editar-setor/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'edit']);
Route::post('/atualizar-setor/{idsb}/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'update']);
Route::get('/excluir-setor/{idsb}/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'delete']);

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
)->name('viewGerenciarCertificados');

Route::get(    '/incluir-certificados/{id}',[\App\Http\Controllers\GerenciarCertificadosController::class, 'create']);

Route::any('/adicionar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'store']);
Route::any('/deletar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'destroy']);

Route::any('/editar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'edit']);

Route::any('/atualizar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'update']);


/**Rota para Entidades Escolares   */
Route::get('/gerenciar-entidades-de-ensino', [App\Http\Controllers\GerenciarEntidadesController::class, 'index'])->name('batata');
Route::get('/incluir-entidades-ensino', [App\Http\Controllers\GerenciarEntidadesController::class, 'create']);
Route::any('/armazenar-entidade', [App\Http\Controllers\GerenciarEntidadesController::class, 'store']);
Route::any('/excluir-entidade/{id}', [App\Http\Controllers\GerenciarEntidadesController::class, 'destroy']);
Route::any('/editar-entidade/{id}', [App\Http\Controllers\GerenciarEntidadesController::class, 'edit']);
Route::any('/atualizar-entidade-ensino/{id}', [App\Http\Controllers\GerenciarEntidadesController::class, 'update']);

/* Rota Para Tipos de Acordos*/
Route::get('/gerenciar-acordos/{id}',[App\Http\Controllers\GerenciarAcordosController::class, 'index'])->name('indexGerenciarAcordos');
Route::get('/incluir-acordos/{id}',[App\Http\Controllers\GerenciarAcordosController::class, 'create']);Route::any('/armazenar-acordos/{id}',[App\Http\Controllers\GerenciarAcordosController::class, 'store']);


/**Rotas de Entrada**/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
