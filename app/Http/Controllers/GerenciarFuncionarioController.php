<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class GerenciarFuncionarioController extends Controller
{

    public function index(Request $request){

        $result=DB::select('select cpf, rg, nome_pessoa, sexo from pessoa');

        $lista = DB::table('pessoa AS p')
        ->select ('p.cpf', 'p.rg', 'p.nome_pessoa', 'sexo');


        $cpf = $request->cpf;

        $rg = $request->idt;

        $nome = $request->nome;


        if ($request->cpf){
            $lista->where('p.cpf', $request->cpf);
        }

        if ($request->idt){
            $lista->where('p.rg', '=', '$request->idt');
        }

        if ($request->nome){
            $lista->where('p.nome_pessoa', 'LIKE', '%'.$request->nome.'%');
        }

        $lista = $lista->orderBy('p.nome_pessoa', 'DESC')->paginate(5);


        //dd($result);

       return view('\funcionarios.gerenciar-funcionario', compact ('lista'));

    }

    public function store(){

        $lista1 = DB::select('select id, tipo from sexo');

        $result=DB::table('pessoa AS p')
                    ->select('pk_pessoa');

        return view('\funcionarios\incluir-funcionario', compact('result', 'lista1'));

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
            'nome' => $request->input('nome_pessoa'),
            'idt' => $request->input('rg'),
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
            'idt' => $request->input('rg'),
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);

        DB::table('endereco')->insert([
            'idt' => $request->input('rg'),
            'cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf')),
            'email' => $request->input('email'),
            'id_genero' => $request->input('genero'),
            'data_nascimento' => $request->input('dt_nascimento'),
            'celular' => preg_replace("/[^0-9]/", "", $request->input('celular')),
            'cep' => str_replace('-','',$request->input('cep')),
            'uf' =>  $request->input('estado')
        ]);

        DB::table('pessoa_endereco')->insert([
            'idt' => $request->input('rg'),
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
