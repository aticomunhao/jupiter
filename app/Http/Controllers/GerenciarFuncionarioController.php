<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use iluminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\pessoa;
use App\Models\funcionario;
use App\Models\Sexo;
use App\Models\pessoal;


class GerenciarFuncionarioController extends Controller
{

    
    public function index(Request $request){

        $teste = $request->session()->all();

       

        $result=DB::connection('mysql')->select('select cpf, idt, nome_completo, sexo from pessoa');

        $lista = DB::connection('mysql')->table('pessoa AS p')
        ->select ('p.id','p.cpf', 'p.idt', 'p.nome_completo', 'p.status');
        
        //->where('p.sexo', '=', '1');

        


        $cpf = $request->cpf;

        $idt = $request->idt;

        $nome = $request->nome;

        $status = $request->status;


        if ($request->cpf){
            $lista->where('p.cpf', $request->cpf);
        }

        if ($request->idt){
            $lista->where('p.idt', '=', $request->idt);
        }

        if ($request->status){
            $lista->where('p.status', '=', $request->status);
        }

        if ($request->nome){
            $lista->where('p.nome_completo', 'LIKE', '%'.$request->nome.'%');
        }

        $lista = $lista->orderBy( 'p.status','asc')->orderBy('p.nome_completo', 'asc')->paginate(5);


        //dd($request->ativo);

       return view('\funcionarios.gerenciar-funcionario', compact ('lista'));

    }

    public function create(){

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

        $ddd = DB::select('select id, descricao, uf_ddd from tp_ddd');

        


        return view('\funcionarios\incluir-funcionario', compact('sexo', 'tp_uf', 'nac', 'cidade', 'programa', 'org_exp', 'cor', 'sangue', 'fator', 'cnh', 'cep', 'logra', 'ddd'));

    }

    public function store(Request $request){

        

        $sexo = DB::select('select id, tipo from tp_sexo');

        $today = Carbon::today()->format('Y-m-d');

        $vercpf = DB::table('pessoa')
                    ->get('cpf');

        

        $cpf = $request->cpf;

        

        if ( $request->$cpf = $vercpf){

           
            app('flasher')->addError('Existe outro cadastro usando este número de CPF');

            return redirect('/informar-dados');
           

        }
        else
        {

            DB::table('pessoa')->insert([
            'nome_completo' => $request->input('nome_completo'),
            'idt' => $request->input('identidade'),
            'orgao_expedidor' =>  $request->input('orgexp'),
            'uf_idt' =>  $request->input('uf_idt'),
            'dt_emissao_idt' =>  $request->input('dt_idt'),
            'dt_nascimento' => $request->input('dt_nascimento'),
            'sexo' => $request->input('sexo'),
            'nacionalidade' => $request->input('pais'),
            'uf_natural' =>  $request->input('uf_nat'),
            'naturalidade' => $request->input('natura'),
            'cpf' => $request->input('cpf'),
            'email' => $request->input('email'),
            'status' => '1',
            
        ]);

        $id_pessoa = DB::table('pessoa')
        ->select(DB::raw('MAX(id) as max_id'))
        ->value('max_id');

      

        DB::table('funcionario')->insert([
            'dt_inicio'=> $request->input('dt_ini'),                        
            'id_pessoa'=> $id_pessoa,            
            'matricula'=> $request->input('matricula'),
            'tp_programa' => $request->input('tp_programa'),
            'nr_programa' => $request->input('programa'),
            'id_cor_pele' => $request->input('cor'),
            'id_tp_sangue' => $request->input('tps'),
            'fator_rh' => $request->input('frh'),
            'titulo_eleitor' => $request->input('titele'),
            'dt_titulo' => $request->input('dt_titulo'),
            'zona_tit' => $request->input('zona'),
            'secao_tit' => $request->input('secao'),
            'ddd' => $request->input('ddd'),
            'celular' => $request->input('celular'),
            'ctps' => $request->input('ctps'),
            'serie' => $request->input('serie_ctps'),
            'uf_ctps' => $request->input('uf_ctps'),
            'dt_emissao_ctps' => $request->input('dt_ctps'),
            'reservista' => $request->input('reservista'),
            'nome_mae' => $request->input('nome_mae'),
            'nome_pai' => $request->input('nome_pai'),
            'id_cat_cnh' => $request->input('cnh'),


        ]);

        DB::table('endereco_pessoas')->insert([
            'cep' => str_replace('-','',$request->input('cep')),
            'id_uf_end' =>  $request->input('uf_end'),
            'id_cidade' => $request->input('cidade'),
             'logradouro' => $request->input('logradouro'),
            'numero' => $request->input('numero'),
            'bairro' => $request->input('bairro'),
            'complemento' => $request->input('comple'),
            'dt_inicio'=> $today, 

            
        ]);

    
       app('flasher')->addSuccess('O cadastro do funcionário foi realizado com sucesso.');
       
       return redirect('/gerenciar-funcionario');
       
      
        }

    }

    public function edit($id){

        $editar = DB::table ('pessoa')
        ->join('funcionario', 'pessoa.id', '=', 'funcionario.id_pessoa',)
        ->join('tp_sangue', 'tp_sangue.id', '=', 'funcionario.id_tp_sangue')
        ->join('tp_programa', 'tp_programa.id', '=', 'funcionario.tp_programa')
        ->join('tp_sexo', 'tp_sexo.id', '=', 'pessoa.sexo')
        ->join('tp_nacionalidade', 'tp_nacionalidade.id', '=', 'pessoa.nacionalidade')
        ->join('tp_cor_pele', 'tp_cor_pele.id', '=', 'funcionario.id_cor_pele')
        ->join('tp_ddd', 'tp_ddd.id', '=', 'funcionario.ddd')
        ->join('tp_uf', 'tp_uf.id', '=', 'funcionario.uf_idt')
        ->select('pessoa.*', 'funcionario.*', 'tp_sangue.*', 'tp_sexo.*',
        'tp_programa.*', 'tp_nacionalidade.*', 'tp_cor_pele.*', 'tp_ddd.*', 'tp_uf.*')
        ->where('id_pessoa', $id)->first();

        $tbsangue = DB::table('tp_sangue')->distinct()->pluck('nome_sangue');
        $tbsexo = DB::table('tp_sexo')->distinct()->pluck('tipo');
        $tbnacionalidade =  DB::table('tp_nacionalidade')->distinct()->pluck('local');
        $tbpele = DB::table('tp_cor_pele')->distinct()->pluck('nome_cor');
        $tbddd = DB::table('tp_ddd')->distinct()->pluck('descricao');
        $tbufidt = DB::table('tp_uf')->distinct()->pluck('sigla');

 
        
    
   // dd($editar);
       //dd($tbsangue);
    //dd($tbsexo);

    
         
        return view('/funcionarios/editar-funcionario', ['editar' => $editar , 'tbsangue'=> $tbsangue, 'tbsexo'=> $tbsexo, 
        'tbnacionalidade'=>$tbnacionalidade, 'tbpele'=>$tbpele, 'tbddd'=>$tbddd, 'tpufidt'=>$tbufidt]);

    }
    

    
    //public function update(Request, $request, $id){


      //  $editar = pessoa::findOnfail($id);
        //$editar->matricula = $request->input('matricula');

        //$editar->save();


        

        //return view('/funcionarios/editar-funcionario');
    //}



       




    }

