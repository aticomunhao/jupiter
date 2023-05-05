<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class GerenciarVoluntarioController extends Controller
{

    public function index(Request $request){

        $result=DB::connection('mysql2')->select('select id_cidade, descricao from cidade');

        $lista = DB::table('pessoa AS p')
        ->select ('p.cpf', 'p.nome_pessoa');

        $cpf = $request->cpf;

        $nome = $request->nome;


        if ($request->cpf){
            $lista->where('p.cpf', $request->cpf);
        }

        if ($request->nome){
            $lista->where('p.nome_pessoa', 'LIKE', '%'.$request->nome.'%');
        }

        $lista = $lista->orderBy('p.nome_pessoa', 'DESC')->paginate(5);


        //dd($result);

       return view('\voluntario.gerenciar-Voluntario', compact ('lista'));

    }

    public function store(){

        $result=DB::table('pessoa AS p')
                    ->select('pk_pessoa');

        return view('\Voluntarios\incluir-voluntario', compact('result', 'lista1'));

    }

    public function insert(Request $request){

        $cidades = DB::connection('mysql2')->select('select id_cidade, descricao from cidade');
        return view('/voluntario/incluir-voluntario',compact('cidades'));

        dd($cidades);

        $vercpf = DB::select('select cpf from pessoa;');

        $cpf = $request->cpf;

        if ($vercpf = $cpf){

            return redirect()
            ->action('GerenciarVoluntarioController@index')
            ->with('danger', 'Este CPF já existe no cadastro do sistema!');

        }
        else
        {

        DB::table('pessoa')->insert([
            'nome' => $request->input('nome_pessoa'),
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

        DB::table('Voluntario')->insert([
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);

        DB::table('endereco')->insert([
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);

        DB::table('pessoa_endereco')->insert([
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);


        return redirect()
        ->action('GerenciarVoluntarioController@index')
        ->with('message', 'Cadastro realizado com sucesso!');
        }

    }

}
