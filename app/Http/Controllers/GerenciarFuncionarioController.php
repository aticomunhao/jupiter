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

        //$lista = DB::connection('mysql')->table('funcionario AS f')
        $lista = DB::table('funcionarios AS f')
        ->leftjoin('pessoas AS p', 'f.id_pessoa', 'p.id')
        ->select ('f.id AS idf','p.cpf', 'p.idt', 'p.nome_completo', 'p.status');

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





       return view('\funcionarios.gerenciar-funcionario', compact ('lista', 'cpf', 'idt', 'status', 'nome'));

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

        $vercpf = DB::table('pessoas')
                    ->get('cpf');

        $cpf = $request->cpf;


        if ( $request->$cpf == $vercpf){


            app('flasher')->addError('Existe outro cadastro usando este número de CPF');

            return redirect('/informar-dados');


        }
        else
        {

            DB::table('pessoas')->insert([
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
            'ddd' => $request->input('ddd'),
            'celular' => $request->input('celular'),
            'status' => '1',

        ]);

        $id_pessoa = DB::table('pessoas')
        ->select(DB::raw('MAX(id) as max_id'))
        ->value('max_id');



        DB::table('funcionarios')->insert([
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

        $editar = DB::table ('pessoas')
        ->join('funcionarios', 'pessoas.id', '=', 'funcionarios.id_pessoa',)
        ->join('tp_sangue', 'tp_sangue.id', '=', 'funcionarios.id_tp_sangue')
        ->join('tp_programa', 'tp_programa.id', '=', 'funcionarios.tp_programa')
        ->join('tp_sexo', 'tp_sexo.id', '=', 'pessoas.sexo')
        ->join('tp_nacionalidade', 'tp_nacionalidade.id', '=', 'pessoas.nacionalidade')
        ->join('tp_cor_pele', 'tp_cor_pele.id', '=', 'funcionarios.id_cor_pele')
        ->join('tp_ddd', 'tp_ddd.id', '=', 'funcionarios.ddd')
        ->join('tp_uf', 'tp_uf.id', '=', 'pessoas.uf_idt')
        ->join('tp_cnh', 'tp_cnh.id', '=', 'funcionarios.id_cat_cnh')
        ->join('tp_cidade', 'tp_cidade.id_cidade', '=', 'pessoas.naturalidade')


        ->select('pessoas.id AS id_pes', 'pessoas.*', 'funcionarios.*', 'tp_sangue.*', 'tp_sexo.*',
        'tp_programa.*', 'tp_nacionalidade.*', 'tp_cor_pele.*', 'tp_ddd.*', 'tp_uf.*', 'tp_cidade.*','tp_cnh.*')
        ->where('id_pessoa', $id)->first();

        $tbsangue = DB::table('tp_sangue')->distinct()->pluck('nome_sangue');
        $tbsexo = DB::table('tp_sexo')->distinct()->pluck('tipo');
        $tbnacionalidade =  DB::table('tp_nacionalidade')->distinct()->pluck('local');
        $tbpele = DB::table('tp_cor_pele')->distinct()->pluck('nome_cor');
        $tbddd = DB::table('tp_ddd')->distinct()->pluck('descricao');
        $tpufidt = DB::table('tp_uf')->distinct()->pluck('sigla');
        $tpcnh = DB::table('tp_cnh')->distinct()->pluck('nome_cat');
        $tpcidade = DB::table('tp_cidade')->distinct()->pluck('descricao');






//dd($editar);
       //dd($tbsangue);
    //dd($tbsexo);


        $tpsexo = DB::table('tp_sexo')->select('id', 'tipo')->get();
        $tpsangue = DB::table('tp_sangue')->select('id', 'nome_sangue')->get();
        $tpnacionalidade =  DB::table('tp_nacionalidade')->select('id', 'local')->get();
        $tppele = DB::table('tp_cor_pele')->select('id', 'nome_cor')->get();
        $tpddd = DB::table('tp_ddd')->select('id', 'descricao')->get();
        $tpufidt = DB::table('tp_uf')->select('id', 'sigla')->get();
        $tpcnh = DB::table('tp_cnh')->select('id', 'nome_cat')->get();
        $tpcidade = DB::table('tp_cidade')->select('id_cidade', 'descricao')->get();
        $tpprograma = DB::table('tp_programa')->select('id', 'programa')->get();



        return view('/funcionarios/editar-funcionario', compact('editar', 'tbsangue', 'tbsexo', 'tbnacionalidade', 'tbpele', 'tbddd', 'tpufidt', 'tpcnh', 'tpcidade'));

    }



    public function update(Request $request, $idf){


       //dd($request);

      DB::table('pessoas')
       ->where('id', $idf)
       ->update(['nome_completo'=>$request->input('nomecompleto'),
                 'idt'=>$request->input('identidade'),
                 'sexo'=>$request->input('sexo'),
                 'dt_nascimento'=>$request->input('dt_de_nascimento'),
                 'nacionalidade'=>$request->input('nacionalidade'),
                 'ddd' => $request->input('ddd'),
                 'celular' => $request->input('celular'),
                 'naturalidade'=>$request->input('natural_cidade'),
                 'cpf'=>$request->input('cpf'),
                 'orgao_expedidor'=>$request->input('orgao_exp'),
                 'dt_emissao_idt'=>$request->input('dt_emissao'),
                 'email'=>$request->input('email')








    ]);

      DB::table('funcionarios')
      ->where('id', $idf)
      ->update([//'tp_programa'=>$request->input('pis'),
                'id_cor_pele'=>$request->input('cor_pele'),
                'id_tp_sangue'=>$request->input('tp_sanguineo'),
                'titulo_eleitor'=>$request->input('tl_eleitor'),
                'zona_tit'=>$request->input('zona'),
                'secao_tit'=>$request->input('secao'),
                'dt_titulo'=>$request->input('dt_emissao'),
                'ctps'=>$request->input('nr_ctps'),
                'dt_emissao_ctps'=>$request->input('dt_emissao_ctps'),
                'serie'=>$request->input('serie'),
                'uf_ctps'=>$request->input('uf'),
                'reservista'=>$request->input('reservista'),
                'nome_mae'=>$request->input('nome_mae'),
                'nome_pai'=>$request->input('nome_pai'),
                'id_cat_cnh'=>$request->input('cat_cnh')





      ]);






        //dd($atualizar);


       //dd($id);
      //dd($nome_completo);
      //dd($dt_nascimento);


        return redirect()->action([GerenciarFuncionarioController::class, 'index']);
   }








    }

