<?php

use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\GerenciarCargos;
use App\Http\Controllers\GerenciarCargosController;
use App\Http\Controllers\GerenciarFeriasController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\GerenciarDadosBancariosController;
use App\Http\Controllers\GerenciarFuncionarioController;

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
/*Gerenciar login*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::any('/', [App\Http\Controllers\LoginController::class, 'index']);
Route::any('/login/valida', [App\Http\Controllers\LoginController::class, 'validaUserLogado'])->name('home.post');
Route::any('/login/home', [App\Http\Controllers\LoginController::class, 'valida']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*Gerenciar funcionario*/

Route::get('/gerenciar-funcionario', [GerenciarFuncionarioController::class, 'index'])->name('gerenciar');
Route::get('/informar-dados', [GerenciarFuncionarioController::class, 'create']);
Route::any('/incluir-funcionario', [GerenciarFuncionarioController::class, 'store']);
Route::get('/editar-funcionario/{idf}', [GerenciarFuncionarioController::class, 'edit']);
Route::get('/excluir-funcionario/{idf}', [GerenciarFuncionarioController::class, 'delete']);
Route::get('/pessoa-funcionario/{idf}', [GerenciarFuncionarioController::class, 'delete']);
Route::get('/retorna-cidade-dados-residenciais/{id}', [GerenciarFuncionarioController::class, 'retornaCidadeDadosResidenciais']);
Route::post('/atualizar-funcionario/{idp}/{idf}', [GerenciarFuncionarioController::class, 'update']);


/*Gerenciar usuário*/

Route::name('usuario')
    ->middleware('validaUsuario')
    ->group(function () {
        Route::get('gerenciar-usuario', 'UsuarioController@index');
        Route::get('usuario-incluir', 'UsuarioController@create');
        Route::get('cadastrar-usuarios/configurar/{id}', 'UsuarioController@configurarUsuario');
        Route::post('/cad-usuario/inserir', 'UsuarioController@store');
        Route::get('/usuario/excluir/{id}', 'UsuarioController@destroy');
        Route::get('/usuario/alterar/{id}', 'UsuarioController@edit');
        Route::put('usuario-atualizar/{id}', 'UsuarioController@update');
        Route::get('/usuario/gerar-Senha/{id}', 'UsuarioController@gerarSenha');
    });


//Route::get('/gerenciar-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'index'])->name('gerenciar-voluntario');
//Route::get('/incluir-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'store']);


/*Gerenciar dados Bancarios*/


Route::get('/gerenciar-dados-bancarios/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'index'])->name('DadoBanc');
Route::any('/incluir-dados-bancarios/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'create']);
Route::any('/armazenar-dados-bancarios/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'store']);
Route::any('/deletar-dado-bancario/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'destroy']);
Route::any('/editar-dado-bancario/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'edit']);
Route::any('/alterar-dado-bancario/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'update']);
Route::any('/recebe-agencias/{id}', [App\Http\Controllers\GerenciarDadosBancariosController::class, 'agencias']);


/*Gerenciar Cargos Regulares*/


Route::get('/gerenciar-cargos-regulares', [App\Http\Controllers\GerenciarCargosRegularesController::class, 'index'])->name('IndexGerenciarCargoRegular');
Route::get('/criar-cargo-regular', [App\Http\Controllers\GerenciarCargosRegularesController::class, 'create']);
Route::any('/incluir-cargo-regular', [App\Http\Controllers\GerenciarCargosRegularesController::class, 'store']);
Route::any('/editar-cargo-regular/{id}', [App\Http\Controllers\GerenciarCargosRegularesController::class, 'edit']);
Route::any('/alterar-cargo-regular/{id}', [App\Http\Controllers\GerenciarCargosRegularesController::class, 'update']);
Route::get('/historico-cargo-regular/{id}', [App\Http\Controllers\GerenciarCargosRegularesController::class, 'show']);
Route::any('/fechar-cargo-regular/{id}', [App\Http\Controllers\GerenciarCargosRegularesController::class, 'destroy']);


// Gerenciar Base Salarial


Route::any('/gerenciar-base-salarial/{idf}', [App\Http\Controllers\GerenciarBaseSalarialController::class, 'index'])->name('GerenciarBaseSalarialController');
Route::any('/incluir-base-salarial/{idf}', [App\Http\Controllers\GerenciarBaseSalarialController::class, 'create'])->name('IncluirBaseSalarial');
Route::any('/vizualizar-base-salarial/{idf}', [App\Http\Controllers\GerenciarBaseSalarialController::class, 'show'])->name('VisualizarBaseSalarial');
Route::any('/armazenar-base-salarial/{idf}', [App\Http\Controllers\GerenciarBaseSalarialController::class, 'store'])->name('ArmazenarBaseSalarial');
Route::any('/retorna-formulario/{idf}', [App\Http\Controllers\GerenciarBaseSalarialController::class, 'retornaFormulario'])->name('retornaFormulario');
Route::any('/editar-base-salarial/{idf}', [Controllers\GerenciarBaseSalarialController::class, 'edit'])->name('EditarBaseSalarial');


/*Gerenciar setores*/


Route::get('/gerenciar-setor', [App\Http\Controllers\GerenciarSetoresController::class, 'index']);
Route::get('/pesquisar-setor', [App\Http\Controllers\GerenciarSetoresController::class, 'index'])->name('pesquisar');
Route::get('/incluir-setor', [App\Http\Controllers\GerenciarSetoresController::class, 'create']);
Route::post('/incluir-setores', [App\Http\Controllers\GerenciarSetoresController::class, 'store']);
Route::get('/editar-setor/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'edit']);
Route::get('/carregar-dados/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'carregar_dados'])->name('substituir');
Route::post('/substituir-setor/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'subst']);
Route::get('/setor-pessoas', [App\Http\Controllers\GerenciarSetoresController::class, 'consult']);
Route::post('/atualizar-setor/{idsb}/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'update']);
Route::get('/excluir-setor/{idsb}/{ids}', [App\Http\Controllers\GerenciarSetoresController::class, 'delete']);


/*Gerenciar-Hierarquia*/


Route::get('/gerenciar-hierarquia', [App\Http\Controllers\GerenciarHierarquiaController::class, 'index'])->name('gerenciar-hierarquia');
Route::get('/obter-setores/{id_nivel}', [App\Http\Controllers\GerenciarHierarquiaController::class, 'obterSetoresPorNivel']);
Route::any('/consultar-hierarquia', [App\Http\Controllers\GerenciarHierarquiaController::class, 'show'])->name('consultar-hierarquia');
Route::any('/atualizar-hierarquia', [App\Http\Controllers\GerenciarHierarquiaController::class, 'atualizarhierarquia']);


/*Gerenciar-Associado*/


Route::get('/pesquisar-associado', [App\Http\Controllers\GerenciarAssociadoController::class, 'index'])->name('pesquisar');
Route::get('/gerenciar-associado', [App\Http\Controllers\GerenciarAssociadoController::class, 'index']);
Route::get('/informar-dados-associado', [App\Http\Controllers\GerenciarAssociadoController::class, 'create']);
Route::get('/retorna-cidade-dados-residenciais', [App\Http\Controllers\GerenciarAssociadoController::class, 'retornaCidadeDadosResidenciais']);
Route::any('/incluir-associado', [App\Http\Controllers\GerenciarAssociadoController::class, 'store']);
Route::get('/editar-associado/{id}', [App\Http\Controllers\GerenciarAssociadoController::class, 'edit']);
Route::any('/atualizar-associado/{ida}/{idp}/{ide}', [App\Http\Controllers\GerenciarAssociadoController::class, 'update']);
Route::get('/editar-associado/{id}', [App\Http\Controllers\GerenciarAssociadoController::class, 'edit']);
Route::get('/gerenciar-dados_bancarios/{id}', [App\Http\Controllers\GerenciarDadosBancariosAssociadoController::class, 'index'])->name('gerenciar-dados-bancario-associado');
Route::get('/visualizar-dados/{id}', [App\Http\Controllers\GerenciarDadosBancariosAssociadoController::class, 'store']);
Route::any('/incluir-dados_bancarios-associado/{ida}', [App\Http\Controllers\GerenciarDadosBancariosAssociadoController::class, 'incluirdadosbancarios']);
Route::get('/editar-dados-bancarios-associado/{ida}', [App\Http\Controllers\GerenciarDadosBancariosAssociadoController::class, 'edit']);
Route::get('/documento-bancario/{ida}', [App\Http\Controllers\GerenciarDadosBancariosAssociadoController::class, 'documentobancariopdf']);
Route::any('/atualizar-dados-bancarios-associado/{ida}/{idt}/{idb}/{idc}', [App\Http\Controllers\GerenciarDadosBancariosAssociadoController::class, 'update']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/capture-photo', [PhotoController::class, 'showCaptureForm'])->name('capture.form');
    Route::post('/capture-photo', [PhotoController::class, 'storeCapturedPhoto']);

});


/*Rotas dos Dependentes */


Route::get('/gerenciar-dependentes/{id}', [App\Http\Controllers\GerenciarDependentesController::class, 'index'])->name('IndexGerenciarDependentes');
Route::get('/incluir-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'create']);
Route::any('/armazenar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'store']);
Route::any('/deletar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'destroy']);
Route::any('/editar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'edit']);
Route::any('/atualizar-dependentes/{id}', [\App\Http\Controllers\GerenciarDependentesController::class, 'update']);


/** Rotas dos Certificados */


Route::get('/gerenciar-certificados/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'index'])->name('viewGerenciarCertificados');
Route::get('/incluir-certificados/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'create']);
Route::any('/adicionar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'store']);
Route::any('/deletar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'destroy']);
Route::any('/editar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'edit']);
Route::any('/atualizar-certificado/{id}', [\App\Http\Controllers\GerenciarCertificadosController::class, 'update']);


/**Rota para Entidades Escolares */


Route::get('/gerenciar-entidades-de-ensino', [App\Http\Controllers\GerenciarEntidadesController::class, 'index'])->name('IndexGerenciarEntidades');
Route::get('/incluir-entidades-ensino', [App\Http\Controllers\GerenciarEntidadesController::class, 'create']);
Route::any('/armazenar-entidade', [App\Http\Controllers\GerenciarEntidadesController::class, 'store']);
Route::any('/excluir-entidade/{id}', [App\Http\Controllers\GerenciarEntidadesController::class, 'destroy']);
Route::any('/editar-entidade/{id}', [App\Http\Controllers\GerenciarEntidadesController::class, 'edit']);
Route::any('/atualizar-entidade-ensino/{id}', [App\Http\Controllers\GerenciarEntidadesController::class, 'update']);


/* Rota Para Tipos de Acordos*/


Route::get('/gerenciar-acordos/{id}', [App\Http\Controllers\GerenciarAcordosController::class, 'index'])->name('indexGerenciarAcordos');
Route::get('/incluir-acordos/{id}', [App\Http\Controllers\GerenciarAcordosController::class, 'create']);
Route::any('/armazenar-acordos/{id}', [App\Http\Controllers\GerenciarAcordosController::class, 'store']);
Route::any('/excluir-acordo/{id}', [App\Http\Controllers\GerenciarAcordosController::class, 'destroy']);
Route::any('/editar-acordo/{id}', [App\Http\Controllers\GerenciarAcordosController::class, 'edit']);
Route::any('/atualizar-acordo/{id}', [App\Http\Controllers\GerenciarAcordosController::class, 'update']);


/**Rotas para Cargos**/


Route::get('/gerenciar-cargos', [App\Http\Controllers\GerenciarCargosController::class, 'index'])->name('gerenciar.cargos');
Route::get('/incluir-cargos', [App\Http\Controllers\GerenciarCargosController::class, 'create']);
Route::get('/editar-cargos/{id}', [App\Http\Controllers\GerenciarCargosController::class, 'edit'])->name('Editar');
Route::post('/armazenar-cargo', [GerenciarCargosController::class, 'store'])->name('armazenaCargo');
Route::any('/deletar-cargos/{id}', [GerenciarCargosController::class, 'destroy']);
Route::get('/vizualizar-historico/{id}', [GerenciarCargosController::class, 'show'])->name('visualizarHistoricoCargo');
Route::any('/atualiza-cargo/{id}', [GerenciarCargosController::class, 'update'])->name('AtualizaCargo');


/**Rotas para Tipo de Desconto**/


Route::get('/gerenciar-tipo-desconto', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'index'])->name('indexTipoDesconto');
Route::get('/incluir-tipo-desconto', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'create']);
Route::get('/editar-tipo-desconto/{id}', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'edit']);
Route::post('/armazenar-tipo-desconto', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'store']);
Route::any('/atualizar-tipo-desconto/{id}', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'update']);
Route::any('/exluir-tipo-desconto/{id}', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'destroy']);
Route::any('/renovar-tipo-desconto/{id}', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'renew']);
Route::any('/modificar-tipo-desconto/{id}', [App\Http\Controllers\GerenciarTipoDescontoController::class, 'modify']);


/**Gerenciar Ferias**/


Route::get('/periodo-de-ferias/', [GerenciarFeriasController::class, 'index'])->name('IndexGerenciarFerias');
Route::get('/incluir-ferias/{id}', [GerenciarFeriasController::class, 'create'])->name('CriarFerias');
Route::any('/armazenar-ferias/{id}', [GerenciarFeriasController::class, 'store'])->name('ArmazenarFerias');
Route::any('/abrir-ferias', [GerenciarFeriasController::class, 'InsereERetornaFuncionarios'])->name('AbreFerias');
Route::any('/administrar-ferias', [GerenciarFeriasController::class, 'administraferias'])->name('AdministrarFerias');
Route::any('/autorizar-ferias/{id}', [GerenciarFeriasController::class, 'autorizarferias'])->name('autorizarFerias');
Route::any('/recusar-ferias/{id}', [GerenciarFeriasController::class, 'recusarPeriodoDeFerias'])->name('recusarFerias');


/**Rotas de Entrada**/


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*Gerenciar Afastamentos*/


Route::any('/gerenciar-afastamentos/{idf}', [App\Http\Controllers\GerenciarAfastamentosController::class, 'index'])->name('indexGerenciarAfastamentos');
Route::any('/incluir-afastamentos/{idf}', [App\Http\Controllers\GerenciarAfastamentosController::class, 'create']);
Route::any('/editar-afastamentos/{idf}', [App\Http\Controllers\GerenciarAfastamentosController::class, 'edit']);
Route::any('/armazenar-afastamentos/{idf}', [App\Http\Controllers\GerenciarAfastamentosController::class, 'store']);
Route::any('/excluir-afastamento/{idf}', [App\Http\Controllers\GerenciarAfastamentosController::class, 'destroy']);
Route::any('/atualizar-afastamento/{idf}', [App\Http\Controllers\GerenciarAfastamentosController::class, 'update']);


/*Gerenciar-Hierarquia*/


Route::get('/gerenciar-efetivo', [App\Http\Controllers\GerenciarEfetivoController::class, 'index'])->name('gerenciar-efetivo');
Route::get('/obter-setores/{id_nivel}', [App\Http\Controllers\GerenciarEfetivoController::class, 'obterSetoresPorNivel']);
Route::any('/consultar-efetivo', [App\Http\Controllers\GerenciarEfetivoController::class, 'show'])->name('consultar-efetivo');
Route::any('/atualizar-efetivo', [App\Http\Controllers\GerenciarEfetivoController::class, 'atualizarefetivo']);



