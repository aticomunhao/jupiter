<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class GerenciarFuncionarioController extends Controller
{

    public function index(Request $request){

        $result=DB::connection('mysql')->select('select cpf, idt, nome_completo, sexo from pessoa');

        $lista = DB::connection('mysql')->table('pessoa AS p')
        ->select ('p.cpf', 'p.idt', 'p.nome_completo', 'p.sexo');
        //->where('p.sexo', '=', '1');


        $cpf = $request->cpf;

        $idt = $request->idt;

        $nome = $request->nome;

        $ativo = $request->ativo;


        if ($request->cpf){
            $lista->where('p.cpf', $request->cpf);
        }

        if ($request->idt){
            $lista->where('p.idt', '=', $request->idt);
        }

        if ($request->ativo){
            $lista->where('p.sexo', '=', $request->ativo);
        }

        if ($request->nome){
            $lista->where('p.nome_completo', 'LIKE', '%'.$request->nome.'%');
        }

        $lista = $lista->orderBy( 'p.sexo','asc')->orderBy('p.nome_completo', 'asc')->paginate(5);


        //dd($request->ativo);

       return view('\funcionarios.gerenciar-funcionario', compact ('lista'));

    }

    public function store(){

        $sexo = DB::select('select id, tipo from tp_sexo');

        $tp_uf = DB::select('select id, sigla from tp_uf');

        $nac = DB::select('select id, local from tp_nacionalidade');

        $cidade = DB::select('select id_cidade, descricao from tp_cidade');

        $programa = DB::select('select id, programa from tp_programa');

        $org_exp = DB::select('select id, sigla from tp_orgao_exp');

        $cor = DB::select('select id, nome_cor from tp_cor_pele');

        $sangue = DB::select('select id, nome_sangue from tp_sangue');

        $fator = DB::select('select id, nome_fator from tp_fator');

        $cnh = DB::select('select id, nome_cat from tp_cnh');

        $cep = DB::select('select id, cep, descricao, descricao_bairro from tp_logradouro');

        $logra = DB::select('select distinct(id), descricao from tp_logradouro');


        return view('\funcionarios\incluir-funcionario', compact('sexo', 'tp_uf', 'nac', 'cidade', 'programa', 'org_exp', 'cor', 'sangue', 'fator', 'cnh', 'cep', 'logra'));

    }

    public function insert(Request $request){

        $vercpf = DB::select('select cpf from pessoa;');

        $cpf = $request->cpf;

        if ($vercpf = $cpf){

            return redirect()
            ->action('GerenciarFuncionarioController@index')
            ->with('danger', 'Este CPF já existe no cadastro do sistema!');

        }
        else
        {

        DB::table('pessoa')->insert([
            'nome_completo' => $request->input('nome_completo'),
            'idt' => $request->input('idt'),
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'dt_nascimento' => $request->input('dt_nascimento'),
            'nacionalidade' => $request->input('pais'),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),

            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado'),
            'localidade' => $request->input('cidade'),
            'bairro' => $request->input('bairro'),
            'logradouro' => $request->input('logradouro'),
            'numero' => $request->input('numero'),
            'complemento' => $request->input('complemento'),
            'gia' => $request->input('gia')
        ]);

        DB::table('funcionario')->insert([
            'idt' => $request->input('idt'),
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);

        DB::table('endereco')->insert([
            'idt' => $request->input('idt'),
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);

        DB::table('pessoa_endereco')->insert([
            'idt' => $request->input('idt'),
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);


        return redirect()
        ->action('GerenciarFuncionarioController@index')
        ->with('message', 'Cadastro realizado com sucesso!');
        }

    }

}
