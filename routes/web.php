<?php

use App\Http\Controllers\ControleVagasController;
use App\Http\Controllers\GerenciarAfastamentosController;
use App\Http\Controllers\GerenciarAssociadoController;
use App\Http\Controllers\GerenciarBaseSalarialController;
use App\Http\Controllers\GerenciarCargos;
use App\Http\Controllers\GerenciarCargosController;
use App\Http\Controllers\GerenciarCertificadosController;
use App\Http\Controllers\GerenciarDadosBancariosAssociadoController;
use App\Http\Controllers\GerenciarDadosBancariosController;
use App\Http\Controllers\GerenciarDependentesController;
use App\Http\Controllers\GerenciarFeriasController;
use App\Http\Controllers\GerenciarFuncionarioController;
use App\Http\Controllers\GerenciarHierarquiaController;
use App\Http\Controllers\GerenciarSetoresController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\GerenciarEntidadesController;
use App\Http\Controllers\GerenciarAcordosController;
use App\Http\Controllers\GerenciarTipoDescontoController;
use App\Http\Controllers\HomeController;

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

Route::any('/login/valida', [LoginController::class, 'validaUserLogado'])->name('home.post');
Route::get('/gerenciar-usuario', [UsuarioController::class, 'index']);

Route::get('/usuario-incluir', [UsuarioController::class, 'create']);
Route::get('/cadastrar-usuarios/configurar/{id}', [UsuarioController::class, 'configurarUsuario']);
Route::post('/cad-usuario/inserir', [UsuarioController::class, 'store']);
Route::get('/usuario/excluir/{id}', [UsuarioController::class, 'destroy']);
Route::get('/usuario/alterar/{id}', [UsuarioController::class, 'edit']);
Route::put('usuario-atualizar/{id}', [UsuarioController::class, 'update']);
Route::any('/usuario/gerar-Senha/{id}', [UsuarioController::class, 'gerarSenha']);

//});

Route::post('/usuario/gravaSenha', [UsuarioController::class, 'gravaSenha']);
Route::get('/usuario/alterar-senha', [UsuarioController::class, 'alteraSenha']);


//Route::get('/gerenciar-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'index'])->name('gerenciar-voluntario');
//Route::get('/incluir-voluntario', [App\Http\Controllers\GerenciarVoluntarioController::class, 'store']);


/*Gerenciar dados Bancarios*/


Route::get('/gerenciar-dados-bancarios/{id}', [GerenciarDadosBancariosController::class, 'index'])->name('DadoBanc');
Route::any('/incluir-dados-bancarios/{id}', [GerenciarDadosBancariosController::class, 'create']);
Route::any('/armazenar-dados-bancarios/{id}', [GerenciarDadosBancariosController::class, 'store']);
Route::any('/deletar-dado-bancario/{id}', [GerenciarDadosBancariosController::class, 'destroy']);
Route::any('/editar-dado-bancario/{id}', [GerenciarDadosBancariosController::class, 'edit']);
Route::any('/alterar-dado-bancario/{id}', [GerenciarDadosBancariosController::class, 'update']);
Route::any('/recebe-agencias/{id}', [GerenciarDadosBancariosController::class, 'agencias']);


// Gerenciar Base Salarial


Route::any('/gerenciar-base-salarial/{idf}', [GerenciarBaseSalarialController::class, 'index'])->name('GerenciarBaseSalarialController');
Route::any('/incluir-base-salarial/{idf}', [GerenciarBaseSalarialController::class, 'create'])->name('IncluirBaseSalarial');
Route::any('/vizualizar-base-salarial/{idf}', [GerenciarBaseSalarialController::class, 'show'])->name('VisualizarBaseSalarial');
Route::any('/armazenar-base-salarial/{idf}', [GerenciarBaseSalarialController::class, 'store'])->name('ArmazenarBaseSalarial');
Route::any('/editar-base-salarial/{idf}', [GerenciarBaseSalarialController::class, 'edit'])->name('EditarBaseSalarial');
Route::any('/atualizar-base-sallarial/{idf}', [GerenciarBaseSalarialController::class, 'update'])->name('AtualizarBaseSalarial');
Route::any('/retorna-cargos-editar/{id}', [GerenciarBaseSalarialController::class, 'retornaCargos']);
Route::any('/retorna-funcao-gratificada', [GerenciarBaseSalarialController::class, 'retornaFG']);


/*Gerenciar setores*/


Route::get('/gerenciar-setor', [GerenciarSetoresController::class, 'index']);
Route::get('/pesquisar-setor', [GerenciarSetoresController::class, 'index'])->name('pesquisar-setor');
Route::get('/incluir-setor', [GerenciarSetoresController::class, 'create']);
Route::post('/incluir-setores', [GerenciarSetoresController::class, 'store']);
Route::get('/editar-setor/{ids}', [GerenciarSetoresController::class, 'edit']);
Route::get('/carregar-dados/{ids}', [GerenciarSetoresController::class, 'carregar_dados'])->name('substituir');
Route::post('/substituir-setor/{ids}', [GerenciarSetoresController::class, 'subst']);
Route::get('/setor-pessoas', [GerenciarSetoresController::class, 'consult']);
Route::post('/atualizar-setor/{ids}', [GerenciarSetoresController::class, 'update']);
Route::get('/excluir-setor/{ids}', [GerenciarSetoresController::class, 'delete']);


/*Gerenciar-Hierarquia*/


Route::get('/gerenciar-hierarquia', [GerenciarHierarquiaController::class, 'index'])->name('gerenciar-hierarquia');
Route::get('/obter-setores/{id_nivel}', [GerenciarHierarquiaController::class, 'obterSetoresPorNivel']);
Route::any('/consultar-hierarquia', [GerenciarHierarquiaController::class, 'show'])->name('consultar-hierarquia');
Route::any('/atualizar-hierarquia', [GerenciarHierarquiaController::class, 'atualizarhierarquia']);


/*Gerenciar-Associado*/


Route::get('/pesquisar-associado', [GerenciarAssociadoController::class, 'index'])->name('pesquisar');
Route::get('/gerenciar-associado', [GerenciarAssociadoController::class, 'index']);
Route::get('/informar-dados-associado', [GerenciarAssociadoController::class, 'create']);
Route::get('/retorna-cidade-dados-residenciais', [GerenciarAssociadoController::class, 'retornaCidadeDadosResidenciais']);
Route::any('/incluir-associado', [GerenciarAssociadoController::class, 'store']);
Route::get('/editar-associado/{id}', [GerenciarAssociadoController::class, 'edit']);
Route::any('/atualizar-associado/{ida}/{idp}/{ide}', [GerenciarAssociadoController::class, 'update']);
Route::get('/editar-associado/{id}', [GerenciarAssociadoController::class, 'edit']);
Route::get('/documento-associado/{id}', [GerenciarAssociadoController::class, 'documentobancariopdf']);
Route::get('/excluir-associado/{id}', [GerenciarAssociadoController::class, 'delete']);
Route::post('/salvar-documento-associado/{id}', [GerenciarAssociadoController::class, 'salvardocumento']);
Route::get('/visualizar-arquivo/{id}', [GerenciarAssociadoController::class, 'visualizardocumento']);

/*Dados Bancarios Associado*/

Route::get('/gerenciar-dados_bancarios/{id}', [GerenciarDadosBancariosAssociadoController::class, 'index'])->name('gerenciar-dados-bancario-associado');
Route::get('/visualizar-dados/{id}', [GerenciarDadosBancariosAssociadoController::class, 'store']);
Route::any('/incluir-dados_bancarios-associado/{ida}', [GerenciarDadosBancariosAssociadoController::class, 'incluirdadosbancarios']);
Route::get('/editar-dados-bancarios-associado/{ida}', [GerenciarDadosBancariosAssociadoController::class, 'edit']);
Route::any('/atualizar-dados-bancarios-associado/{ida}/{idt}/{idb}/{idc}', [GerenciarDadosBancariosAssociadoController::class, 'update']);
Route::get('/documento-bancario/{ida}', [GerenciarDadosBancariosAssociadoController::class, 'documentobancariopdf']);
Route::post('/carregar-documento', [GerenciarDadosBancariosAssociadoController::class, 'carregar_documento']);
Route::post('/salvar-documento-bancario/{ida}', [GerenciarDadosBancariosAssociadoController::class, 'salvardocumentobancario']);
Route::get('/visualizar-arquivo/{ida}', [GerenciarDadosBancariosAssociadoController::class, 'visualizardocumentobancario']);
Route::get('/excluir-dados-bancarios-associado/{ida}', [GerenciarDadosBancariosAssociadoController::class, 'delete']);

/*PhotoController*/
Route::get('/capture-photo/{id}', [PhotoController::class, 'showCaptureForm'])->name('capture.form');
Route::post('/capture-photo', [PhotoController::class, 'storeCapturedPhoto']);
Route::any('/visualizar-foto', [PhotoController::class, 'visualizarfoto']);


/*Rotas dos Dependentes */


Route::get('/gerenciar-dependentes/{id}', [GerenciarDependentesController::class, 'index'])->name('IndexGerenciarDependentes');
Route::get('/incluir-dependentes/{id}', [GerenciarDependentesController::class, 'create']);
Route::any('/armazenar-dependentes/{id}', [GerenciarDependentesController::class, 'store']);
Route::any('/deletar-dependentes/{id}', [GerenciarDependentesController::class, 'destroy']);
Route::any('/editar-dependentes/{id}', [GerenciarDependentesController::class, 'edit']);
Route::any('/atualizar-dependentes/{id}', [GerenciarDependentesController::class, 'update']);


/** Rotas dos Certificados */


Route::get('/gerenciar-certificados/{id}', [GerenciarCertificadosController::class, 'index'])->name('viewGerenciarCertificados');
Route::get('/incluir-certificados/{id}', [GerenciarCertificadosController::class, 'create']);
Route::any('/adicionar-certificado/{id}', [GerenciarCertificadosController::class, 'store']);
Route::any('/deletar-certificado/{id}', [GerenciarCertificadosController::class, 'destroy']);
Route::any('/editar-certificado/{id}', [GerenciarCertificadosController::class, 'edit']);
Route::any('/atualizar-certificado/{id}', [GerenciarCertificadosController::class, 'update']);


/**Rota para Entidades Escolares */


Route::get('/gerenciar-entidades-de-ensino', [GerenciarEntidadesController::class, 'index'])->name('IndexGerenciarEntidades');
Route::get('/incluir-entidades-ensino', [GerenciarEntidadesController::class, 'create']);
Route::any('/armazenar-entidade', [GerenciarEntidadesController::class, 'store']);
Route::any('/excluir-entidade/{id}', [GerenciarEntidadesController::class, 'destroy']);
Route::any('/editar-entidade/{id}', [GerenciarEntidadesController::class, 'edit']);
Route::any('/atualizar-entidade-ensino/{id}', [GerenciarEntidadesController::class, 'update']);


/* Rota Para Tipos de Acordos*/


Route::get('/gerenciar-acordos/{id}', [GerenciarAcordosController::class, 'index'])->name('indexGerenciarAcordos');
Route::get('/incluir-acordos/{id}', [GerenciarAcordosController::class, 'create']);
Route::any('/armazenar-acordos/{id}', [GerenciarAcordosController::class, 'store']);
Route::any('/excluir-acordo/{id}', [GerenciarAcordosController::class, 'destroy']);
Route::any('/editar-acordo/{id}', [GerenciarAcordosController::class, 'edit']);
Route::any('/atualizar-acordo/{id}', [GerenciarAcordosController::class, 'update']);


/**Rotas para Cargos**/


Route::get('/gerenciar-cargos', [GerenciarCargosController::class, 'index'])->name('gerenciar.cargos');
Route::get('/incluir-cargos', [GerenciarCargosController::class, 'create']);
Route::get('/editar-cargos/{id}', [GerenciarCargosController::class, 'edit'])->name('Editar');
Route::post('/armazenar-cargo', [GerenciarCargosController::class, 'store'])->name('armazenaCargo');
Route::any('/deletar-cargos/{id}', [GerenciarCargosController::class, 'destroy']);
Route::get('/vizualizar-historico/{id}', [GerenciarCargosController::class, 'show'])->name('visualizarHistoricoCargo');
Route::any('/atualiza-cargo/{id}', [GerenciarCargosController::class, 'update'])->name('AtualizaCargo');


/**Rotas para Tipo de Desconto**/


Route::get('/gerenciar-tipo-desconto', [GerenciarTipoDescontoController::class, 'index'])->name('indexTipoDesconto');
Route::get('/incluir-tipo-desconto', [GerenciarTipoDescontoController::class, 'create']);
Route::get('/editar-tipo-desconto/{id}', [GerenciarTipoDescontoController::class, 'edit']);
Route::post('/armazenar-tipo-desconto', [GerenciarTipoDescontoController::class, 'store']);
Route::any('/atualizar-tipo-desconto/{id}', [GerenciarTipoDescontoController::class, 'update']);
Route::any('/exluir-tipo-desconto/{id}', [GerenciarTipoDescontoController::class, 'destroy']);
Route::any('/renovar-tipo-desconto/{id}', [GerenciarTipoDescontoController::class, 'renew']);
Route::any('/modificar-tipo-desconto/{id}', [GerenciarTipoDescontoController::class, 'modify']);


/**Gerenciar Ferias**/


Route::get('/periodo-de-ferias/', [GerenciarFeriasController::class, 'index'])->name('IndexGerenciarFerias');
Route::get('/incluir-ferias/{id}', [GerenciarFeriasController::class, 'create'])->name('CriarFerias');
Route::any('/armazenar-ferias/{id}', [GerenciarFeriasController::class, 'update'])->name('ArmazenarFerias');
Route::any('/abrir-ferias', [GerenciarFeriasController::class, 'InsereERetornaFuncionarios'])->name('AbreFerias');
Route::any('/administrar-ferias', [GerenciarFeriasController::class, 'administraferias'])->name('AdministrarFerias');
Route::any('/autorizar-ferias/{id}', [GerenciarFeriasController::class, 'autorizarferias'])->name('autorizarFerias');
Route::any('/formulario-recusar-ferias/{id}', [GerenciarFeriasController::class, 'formulario_recusa_periodo_de_ferias'])->name('FormularioFerias');
Route::any('/recusa-ferias/{id}', [GerenciarFeriasController::class, 'recusa_pedido_de_ferias'])->name('RecusaFerias');
Route::any('/visualizar-historico-recusa-ferias/{id}', [GerenciarFeriasController::class, 'show'])->name('HistoricoRecusaFerias');
Route::any('/enviar-ferias', [GerenciarFeriasController::class, 'enviarFerias'])->name('enviar-ferias');
Route::any('/reabrir-formulario/{id}', [GerenciarFeriasController::class, 'reabrirFormulario'])->name('ReabrirFormulario');


/**Rotas de Entrada**/


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');


/*Gerenciar Afastamentos*/


Route::any('/gerenciar-afastamentos/{idf}', [GerenciarAfastamentosController::class, 'index'])->name('indexGerenciarAfastamentos');
Route::any('/incluir-afastamentos/{idf}', [GerenciarAfastamentosController::class, 'create']);
Route::any('/editar-afastamentos/{idf}', [GerenciarAfastamentosController::class, 'edit']);
Route::any('/armazenar-afastamentos/{idf}', [GerenciarAfastamentosController::class, 'store']);
Route::any('/excluir-afastamento/{idf}', [GerenciarAfastamentosController::class, 'destroy']);
Route::any('/atualizar-afastamento/{idf}', [GerenciarAfastamentosController::class, 'update']);


/*Controle de Efetivo*/


Route::get('/gerenciar-efetivo', [App\Http\Controllers\GerenciarEfetivoController::class, 'index'])->name('gerenciar-efetivo');


/*Controle de Vagas*/

Route::get('/controle-vagas', [ControleVagasController::class, 'index'])->name('indexControleVagas');
Route::any('/incluir-vagas', [ControleVagasController::class, 'create']);
Route::any('/armazenar-vagas', [ControleVagasController::class, 'store']);
Route::get('/editar-vagas/{idC}', [ControleVagasController::class, 'edit']);
Route::any('/excluir-vagas/{idC}', [ControleVagasController::class, 'destroy']);
Route::any('/atualizar-vagas/{idC}', [ControleVagasController::class, 'update']);
