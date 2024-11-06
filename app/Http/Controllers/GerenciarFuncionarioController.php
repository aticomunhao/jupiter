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
use PhpParser\Node\Stmt\ElseIf_;

use function Laravel\Prompts\select;

class GerenciarFuncionarioController extends Controller
{


    public function index(Request $request)
    {

        $lista = DB::table('funcionarios AS f')
            ->leftjoin('pessoas AS p', 'f.id_pessoa', 'p.id')
            ->leftJoin('setor', 'setor.id', 'f.id_setor')
            ->leftJoin('acordo', 'acordo.id_funcionario', 'f.id')
            ->select(
                'f.id AS idf',
                'p.cpf',
                'p.idt',
                'p.nome_completo',
                'p.status',
                'f.id_pessoa AS idp',
                'p.nome_resumido',
                'setor.sigla',
                DB::raw('MAX(acordo.motivo) AS motivo'), // Selecione o motivo do último acordo
                DB::raw('MAX(acordo.id) AS id_acordo') // Selecione o ID do último acordo
            )
            ->groupBy(
                'f.id',
                'p.cpf',
                'p.idt',
                'p.nome_completo',
                'p.status',
                'f.id_pessoa',
                'p.nome_resumido',
                'setor.sigla'
            ); // Agrupe por todas as colunas do funcionário

        $cpf = $request->cpf;


        $idt = $request->idt;

        $nome = $request->nome;

        $status = $request->status;


        if ($request->cpf) {
            $lista->where('p.cpf', $request->cpf);
        }

        if ($request->idt) {
            $lista->where('p.idt', '=', $request->idt);
        }
        if ($request->status == null || $request->status == '1') {
            // Considera funcionário ativo se status é 1 e possui ao menos um acordo sem dt_fim (em aberto)
            $lista->where('p.status', 1)
                ->where(function ($query) {
                    $query->whereNull('acordo.motivo')
                        ->orWhere(function ($subquery) {
                            $subquery->whereNull('acordo.dt_fim')
                                ->where('acordo.admissao', true);
                        });
                });
        } elseif ($request->status == '0') {
            $lista->where(function ($query) {
                $query->whereNotNull('acordo.motivo')
                    ->orWhere('p.status', 0);
            });
        }


        if ($request->nome) {
            $lista->whereRaw("UNACCENT(LOWER(p.nome_completo)) ILIKE UNACCENT(LOWER(?))", ["%{$request->nome}%"]);
        }
        if ($request->setor) {
            $lista->where('f.id_setor', '=', $request->setor);
        }

        $lista = $lista->orderBy('p.status', 'asc')->orderBy('p.nome_completo', 'asc')->paginate(10);

        $situacao = DB::table('tp_demissao')
            ->select(
                'tp_demissao.motivo',
                'tp_demissao.id',
            )
            ->get();

        $setor = db::table('setor')
            ->select('id', 'nome', 'sigla')
            ->orderBy('sigla')
            ->get();

            $totalFuncionariosAtivos = DB::table('funcionarios AS f')
            ->leftJoin('pessoas AS p', 'p.id', '=', 'f.id_pessoa')
            ->leftJoin('acordo', 'acordo.id_funcionario', '=', 'f.id')
            ->where('p.status', 1)
            ->where(function ($query) {
                $query->whereNull('acordo.motivo')
                    ->orWhereExists(function ($subquery) {
                        $subquery->select(DB::raw(1))
                            ->from('acordo')
                            ->whereColumn('acordo.id_funcionario', 'f.id')
                            ->whereNull('acordo.dt_fim');
                    });
            })
            ->count();


        $totalFuncionariosInativos = DB::table('funcionarios AS f')
            ->leftJoin('pessoas AS p', 'p.id', '=', 'f.id_pessoa')
            ->leftJoin('acordo', 'acordo.id_funcionario', '=', 'f.id')
            ->where(function ($query) {
                $query->whereNotNull('acordo.motivo')
                    ->orWhere('p.status', 0);
            })
            ->whereNotExists(function ($subquery) {
                $subquery->select(DB::raw(1))
                    ->from('acordo')
                    ->whereColumn('acordo.id_funcionario', 'f.id')
                    ->whereNull('acordo.dt_fim');
            })
            ->count();


        return view('/funcionarios.gerenciar-funcionario', compact('lista', 'cpf', 'idt', 'status', 'nome', 'situacao', 'setor', 'totalFuncionariosAtivos', 'totalFuncionariosInativos'));
    }

    public function create()
    {

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

        $setor = DB::select('select id, nome from setor order by nome');

        return view('/funcionarios.incluir-funcionario', compact('sexo', 'tp_uf', 'nac', 'cidade', 'programa', 'org_exp', 'cor', 'sangue', 'fator', 'cnh', 'cep', 'logra', 'ddd', 'setor'));
    }

    public function store(Request $request)
    {

        $sexo = DB::select('select id, tipo from tp_sexo');

        $today = Carbon::today()->format('Y-m-d');

        $cpf = $request->cpf;

        $vercpf = DB::table('pessoas')->where('cpf', $cpf)->exists();


        $verpessoa = DB::select("
            SELECT EXISTS (
                SELECT *
                FROM pessoas p
                LEFT JOIN funcionarios f ON (f.id_pessoa = p.id)
                WHERE (p.cpf = '$cpf')
                AND (f.id_pessoa IS NOT NULL OR p.id = f.id_pessoa)
            ) AS exists;
            ");

        $exists = $verpessoa[0]->exists;


        try {
            $validated = $request->validate([
                'cpf' => 'required|cpf',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            app('flasher')->addError('Este CPF não é válido');
            return redirect()->back()->withInput();
        }

        if ($exists) {

            app('flasher')->addError('Existe outro cadastro usando este número de CPF');
            return redirect()->back()->withInput();
        } elseif ($vercpf) {

            DB::table('pessoas')
                ->where('cpf', $cpf)
                ->update([
                    'nome_completo' => $request->input('nome_completo'),
                    'nome_resumido' => $request->input('nome_resumido'),
                    'idt' => $request->input('identidade'),
                    'orgao_expedidor' => $request->input('orgexp'),
                    'uf_idt' => $request->input('uf_idt'),
                    'dt_emissao_idt' => $request->input('dt_idt'),
                    'dt_nascimento' => $request->input('dt_nascimento'),
                    'sexo' => $request->input('sex'),
                    'nacionalidade' => $request->input('pais'),
                    'uf_natural' => $request->input('uf_nat'),
                    'naturalidade' => $request->input('natura'),
                    'cpf' => $request->input('cpf'),
                    'email' => $request->input('email'),
                    'ddd' => $request->input('ddd'),
                    'celular' => $request->input('celular'),
                    'status' => '1'
                ]);

            $id_pessoa = DB::table('pessoas')
                ->select('pessoas.id AS idFuncionario')
                ->where('pessoas.cpf', $cpf)
                ->value('idFuncionario');


            DB::table('funcionarios')->insert([
                'id_pessoa' => $id_pessoa,
                'dt_inicio' => $request->input('dt_ini'),
                'matricula' => $request->input('matricula'),
                'tp_programa' => $request->input('tp_programa'),
                'nr_programa' => $request->input('nr_programa'),
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
                'id_setor' => $request->input('setor')
            ]);

            $id_funcionario = DB::table('funcionarios')
                ->leftJoin('pessoas', 'pessoas.id', 'funcionarios.id_pessoa')
                ->select('funcionarios.id AS idf')
                ->where('pessoas.cpf', $cpf)
                ->value('idf');

            DB::table('situacao_contrato')
                ->insert([
                    'id_funcionario' => $id_funcionario,
                    'dt_inicio' => $request->input('dt_ini'),

                ]);

            DB::table('endereco_pessoas')
                ->insert([
                    'id_pessoa' => $id_pessoa,
                    'cep' => str_replace('-', '', $request->input('cep')),
                    'id_uf_end' => $request->input('uf_end'),
                    'id_cidade' => $request->input('cidade'),
                    'logradouro' => $request->input('logradouro'),
                    'numero' => $request->input('numero'),
                    'bairro' => $request->input('bairro'),
                    'complemento' => $request->input('comple'),
                    'dt_inicio' => $today

                ]);

            app('flasher')->addWarning('Cadastro de funcionário realizado com base nos dados ja existentes da pessoa.');
            return redirect('/gerenciar-funcionario');
        } else {

            DB::table('pessoas')->insert([
                'nome_completo' => $request->input('nome_completo'),
                'nome_resumido' => $request->input('nome_resumido'),
                'idt' => $request->input('identidade'),
                'orgao_expedidor' => $request->input('orgexp'),
                'uf_idt' => $request->input('uf_idt'),
                'dt_emissao_idt' => $request->input('dt_idt'),
                'dt_nascimento' => $request->input('dt_nascimento'),
                'sexo' => $request->input('sex'),
                'nacionalidade' => $request->input('pais'),
                'uf_natural' => $request->input('uf_nat'),
                'naturalidade' => $request->input('natura'),
                'cpf' => $request->input('cpf'),
                'email' => $request->input('email'),
                'ddd' => $request->input('ddd'),
                'celular' => $request->input('celular'),
                'status' => '1',

            ]);


            $id_pessoa = DB::table('pessoas')
                ->max('id');


            //dd($id_pessoa);


            DB::table('funcionarios')->insert([
                'id_pessoa' => $id_pessoa,
                'dt_inicio' => $request->input('dt_ini'),
                'matricula' => $request->input('matricula'),
                'tp_programa' => $request->input('tp_programa'),
                'nr_programa' => $request->input('nr_programa'),
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
                'id_setor' => $request->input('setor')
            ]);

            $id_funcionario = DB::table('funcionarios')
                ->leftJoin('pessoas', 'pessoas.id', 'funcionarios.id_pessoa')
                ->select('funcionarios.id AS idf')
                ->where('pessoas.cpf', $cpf)
                ->value('idf');

            DB::table('situacao_contrato')
                ->insert([
                    'id_funcionario' => $id_funcionario,
                    'dt_inicio' => $request->input('dt_ini'),

                ]);

            DB::table('endereco_pessoas')->insert([
                'id_pessoa' => $id_pessoa,
                'cep' => str_replace('-', '', $request->input('cep')),
                'id_uf_end' => $request->input('uf_end'),
                'id_cidade' => $request->input('cidade'),
                'logradouro' => $request->input('logradouro'),
                'numero' => $request->input('numero'),
                'bairro' => $request->input('bairro'),
                'complemento' => $request->input('comple'),
                'dt_inicio' => $today

            ]);

            app('flasher')->addSuccess('O cadastro do funcionário foi realizado com sucesso.');
            return redirect('/gerenciar-funcionario');
        }
    }


    public function edit($idp)
    {
        $identidade = DB::table('pessoas AS pa')
            ->leftJoin('tp_uf', 'pa.uf_idt', 'tp_uf.id')
            ->select('tp_uf.sigla AS sigla_identidade', 'pa.uf_idt')
            ->where('pa.id', $idp)
            ->get();

        $pessoa = DB::table('pessoas AS p')
            ->leftJoin('tp_sexo', 'p.sexo', 'tp_sexo.id')
            ->leftJoin('tp_nacionalidade', 'p.nacionalidade', 'tp_nacionalidade.id')
            ->leftJoin('tp_uf', 'p.uf_natural', 'tp_uf.id')
            ->leftJoin('tp_cidade', 'p.naturalidade', 'tp_cidade.id_cidade')
            ->leftJoin('tp_orgao_exp', 'p.orgao_expedidor', 'tp_orgao_exp.id')
            ->leftJoin('tp_ddd', 'p.ddd', 'tp_ddd.id')
            ->select(
                'p.id AS idp',
                'p.nome_completo AS nome_completo',
                'p.nome_resumido AS nome_resumido',
                'p.idt AS identidade',
                'p.uf_idt AS uf_identidade',
                'p.orgao_expedidor AS id_orgao_expedidor',
                'p.dt_emissao_idt AS dt_emissao_identidade',
                'p.dt_nascimento AS dt_nascimento',
                'p.uf_natural AS uf_naturalidade',
                'p.naturalidade AS naturalidade',
                'p.nacionalidade AS nacionalidade',
                'p.sexo AS id_sexo',
                'p.email AS email',
                'p.ddd AS ddd',
                'p.celular AS celular',
                'p.cpf AS cpf',
                'tp_sexo.tipo AS nome_sexo',
                'tp_nacionalidade.local AS nome_nacionalidade',
                'tp_uf.sigla AS sigla_naturalidade',
                'tp_cidade.descricao AS descricao_cidade',
                'tp_orgao_exp.sigla AS sigla_orgao_expedidor',
                'tp_ddd.descricao AS numero_ddd',
            )
            ->where('p.id', $idp)
            ->get();


        $funcionario = DB::table('funcionarios AS f')
            ->leftJoin('tp_programa', 'f.tp_programa', 'tp_programa.id')
            ->leftJoin('tp_cor_pele', 'f.id_cor_pele', 'tp_cor_pele.id')
            ->leftJoin('tp_sangue', 'f.id_tp_sangue', 'tp_sangue.id')
            ->leftJoin('tp_fator', 'f.fator_rh', 'tp_fator.id')
            ->leftJoin('tp_uf', 'f.uf_ctps', 'tp_uf.id')
            ->leftJoin('tp_cnh', 'f.id_cat_cnh', 'tp_cnh.id')
            ->leftJoin('setor', 'f.id_setor', 'setor.id')
            ->select(
                'f.matricula AS matricula',
                'f.ctps AS ctps',
                'f.uf_ctps AS uf_ctps',
                'f.serie AS serie_ctps',
                'f.dt_emissao_ctps AS emissao_ctps',
                'f.tp_programa AS tp_programa',
                'f.nr_programa AS nr_programa',
                'f.reservista AS reservista',
                'f.id_cat_cnh AS id_tp_cnh',
                'f.id_cor_pele AS tp_cor',
                'f.id_tp_sangue AS tp_sangue',
                'f.nome_mae AS nome_mae',
                'f.nome_pai AS nome_pai',
                'f.fator_rh AS id_fator_rh',
                'f.titulo_eleitor AS titulo_eleitor',
                'f.zona_tit AS zona_titulo',
                'f.secao_tit AS secao_titulo',
                'f.dt_titulo AS dt_titulo',
                'f.id_setor AS id_setor',
                'f.dt_inicio AS dt_inicio',
                'tp_programa.programa AS nome_programa',
                'tp_cor_pele.nome_cor AS nome_cor',
                'tp_sangue.nome_sangue AS nome_sangue',
                'tp_fator.nome_fator AS nome_fator',
                'tp_uf.sigla AS sigla_ctps',
                'tp_cnh.nome_cat AS tp_cnh',
                'setor.nome AS nome_setor'
            )
            ->where('f.id_pessoa', $idp)
            ->get();

        $endereco = DB::table('endereco_pessoas AS ep')
            ->leftJoin('tp_cidade', 'ep.id_cidade', 'tp_cidade.id_cidade')
            ->leftJoin('tp_uf', 'ep.id_uf_end', 'tp_uf.id')
            ->select(
                'ep.cep AS cep',
                'ep.id_uf_end AS uf_endereco',
                'ep.id_cidade AS cidade',
                'ep.logradouro AS logradouro',
                'ep.numero AS numero',
                'ep.bairro AS bairro',
                'ep.complemento AS complemento',
                'tp_cidade.descricao AS nome_cidade',
                'tp_uf.sigla AS sigla_uf_endereco',
            )
            ->where('id_pessoa', $idp)
            ->get();

        //dd($pessoa, $funcionario, $endereco);
        //Join com a tabela endereco
        $tp_ufe = DB::select('select id, sigla from tp_uf');

        // Joins com a tabela pessoa
        $tpsexo = DB::table('tp_sexo')->select('id', 'tipo')->get();
        $tpnacionalidade = DB::table('tp_nacionalidade')->select('id', 'local')->get();
        $tp_uf = DB::select('select id, sigla from tp_uf');
        $tporg_exp = DB::select('select id, sigla from tp_orgao_exp');
        $tpddd = DB::table('tp_ddd')->select('id', 'descricao')->get();
        $tpcidade = DB::table('tp_cidade')->select('id_cidade', 'descricao')->get();
        $tp_ufi = DB::select('select id, sigla from tp_uf');


        // Joins com a tabela funcionario
        $tpprograma = DB::table('tp_programa')->select('id', 'programa')->get();
        $tppele = DB::table('tp_cor_pele')->select('id', 'nome_cor')->get();
        $tpsangue = DB::table('tp_sangue')->select('id', 'nome_sangue')->get();
        $fator = DB::select('select id, nome_fator from tp_fator');
        $tp_uff = DB::select('select id, sigla from tp_uf');
        $tpcnh = DB::table('tp_cnh')->select('id', 'nome_cat')->get();
        $tpsetor = DB::table('setor')->select('id', 'nome')->get();



        return view('/funcionarios/editar-funcionario', compact('identidade', 'pessoa', 'funcionario', 'endereco', 'tpsangue', 'tpsexo', 'tpnacionalidade', 'tppele', 'tpddd', 'tp_uf', 'tpcnh', 'tpcidade', 'tpprograma', 'tpsetor', 'tporg_exp', 'fator', 'tp_uff', 'tp_ufi', 'tp_ufe'));
    }


    public function update(Request $request, $idp)
    {
        $cpf = $request->cpf;

        try {
            $validated = $request->validate([
                'cpf' => 'required|cpf',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            app('flasher')->addError('Este CPF não é válido');

            return redirect()->back()->withInput();
        }

        DB::table('pessoas')
            ->where('id', $idp)
            ->update([
                'nome_completo' => $request->input('nome_completo'),
                'nome_resumido' => $request->input('nome_resumido'),
                'idt' => $request->input('identidade'),
                'orgao_expedidor' => $request->input('orgexp'),
                'uf_idt' => $request->input('uf_idt'),
                'dt_emissao_idt' => $request->input('dt_idt'),
                'dt_nascimento' => $request->input('dt_nascimento'),
                'sexo' => $request->input('sexo'),
                'nacionalidade' => $request->input('pais'),
                'uf_natural' => $request->input('uf_nat'),
                'naturalidade' => $request->input('natura'),
                'cpf' => $request->input('cpf'),
                'email' => $request->input('email'),
                'ddd' => $request->input('ddd'),
                'celular' => $request->input('celular'),
            ]);


        DB::table('funcionarios')
            ->where('id_pessoa', $idp)
            ->update([
                'dt_inicio' => $request->input('dt_ini'),
                'matricula' => $request->input('matricula'),
                'tp_programa' => $request->input('tp_programa'),
                'nr_programa' => $request->input('nr_programa'),
                'id_cor_pele' => $request->input('cor'),
                'id_tp_sangue' => $request->input('tps'),
                'fator_rh' => $request->input('fator'),
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
                'id_setor' => $request->input('setor')

            ]);

        $id_funcionario = DB::table('funcionarios')
            ->leftJoin('pessoas', 'pessoas.id', 'funcionarios.id_pessoa')
            ->select('funcionarios.id AS idf')
            ->where('pessoas.id', $idp)
            ->value('idf');

        DB::table('situacao_contrato')
            ->where('situacao_contrato.id_funcionario', $id_funcionario)
            ->update([
                'id_funcionario' => $id_funcionario,
                'dt_inicio' => $request->input('dt_ini'),

            ]);

        DB::table('endereco_pessoas')
            ->where('id_pessoa', $idp)
            ->update([
                'cep' => str_replace('-', '', $request->input('cep')),
                'id_uf_end' => $request->input('uf_end'),
                'id_cidade' => $request->input('cidade'),
                'logradouro' => $request->input('logradouro'),
                'numero' => $request->input('numero'),
                'bairro' => $request->input('bairro'),
                'complemento' => $request->input('comple'),
            ]);

        app('flasher')->addSuccess('Edição feita com Sucesso!');
        return redirect('/gerenciar-funcionario');
    }

    public function delete($idp)
    {

        $funcionario = DB::table('funcionarios')->select('funcionarios.id AS idf')->where('id_pessoa', $idp)->get();

        $dependentes = DB::select('select * from dependentes');

        $funcionario = $funcionario[0];
        //dd($dependentes, $funcionario);

        foreach ($dependentes as $dependente) {

            if ($funcionario->idf == $dependente->id_funcionario) {
                app('flasher')->addWarning("Não foi possivel excluir o funcionário, pois o dependente $dependente->nome_dependente está cadastrado");
                return redirect()->action([GerenciarFuncionarioController::class, 'index']);
            }
        }

        $certficado = DB::select('select * from certificados');

        foreach ($certficado as $certificados) {

            if ($funcionario->idf == $certificados->id_funcionario) {
                app('flasher')->addWarning("Não foi possivel excluir o funcionário, pois possui certificado cadastrado com o nome de $certificados->nome");
                return redirect()->action([GerenciarFuncionarioController::class, 'index']);
            }
        }


        $dados_bancario = DB::select('select * from dados_bancarios');


        foreach ($dados_bancario as $dados_bancarios) {
            if ($funcionario->id_pessoa == $dados_bancarios->id_pessoa) {

                app('flasher')->addWarning("Não foi possivel excluir o funcionário, pois o dependente $dependente->nome_dependente está cadastrado");
            }
        }


        DB::table('funcionarios')->where('id_pessoa', $idp)->delete();
        DB::table('endereco_pessoas')->where('id_pessoa', $idp)->delete();


        app('flasher')->addSuccess('O cadastro do funcionário foi Removido com Sucesso.');
        return redirect()->action([GerenciarFuncionarioController::class, 'index']);
    }

    public function pes_func($idp)
    {

        $up = DB::table('pessoas As p')
            ->select('p.nome_completo', 'p.celular', 'p.email')
            ->where('id', $idp);


        $tpsexo = DB::table('tp_sexo')->select('id', 'tipo')->get();
        $tpnacionalidade = DB::table('tp_nacionalidade')->select('id', 'local')->get();
        $tpddd = DB::table('tp_ddd')->select('id', 'descricao')->get();
        $tpufidt = DB::table('tp_uf')->select('id', 'sigla')->get();
    }

    public function retornaCidadeDadosResidenciais($id)
    {
        $cidadeDadosResidenciais = DB::table('tp_cidade')
            ->where('id_uf', $id)
            ->get();

        return response()->json($cidadeDadosResidenciais);
    }

    public function retornacidadesNaturalidade($id)
    {
        $cidadeNaturalidade = DB::table('tp_cidade')
            ->where('id_uf', $id)
            ->get();
        return response()->json($cidadeNaturalidade);
    }
    public function show($idp)
    {
        $identidade = DB::table('pessoas AS pa')
            ->leftJoin('tp_uf', 'pa.uf_idt', 'tp_uf.id')
            ->select('tp_uf.sigla AS sigla_identidade', 'pa.uf_idt')
            ->where('pa.id', $idp)
            ->get();

        $pessoa = DB::table('pessoas AS p')
            ->leftJoin('tp_sexo', 'p.sexo', 'tp_sexo.id')
            ->leftJoin('tp_nacionalidade', 'p.nacionalidade', 'tp_nacionalidade.id')
            ->leftJoin('tp_uf', 'p.uf_natural', 'tp_uf.id')
            ->leftJoin('tp_cidade', 'p.naturalidade', 'tp_cidade.id_cidade')
            ->leftJoin('tp_orgao_exp', 'p.orgao_expedidor', 'tp_orgao_exp.id')
            ->leftJoin('tp_ddd', 'p.ddd', 'tp_ddd.id')
            ->select(
                'p.id AS idp',
                'p.nome_completo AS nome_completo',
                'p.nome_resumido AS nome_resumido',
                'p.idt AS identidade',
                'p.uf_idt AS uf_identidade',
                'p.orgao_expedidor AS id_orgao_expedidor',
                'p.dt_emissao_idt AS dt_emissao_identidade',
                'p.dt_nascimento AS dt_nascimento',
                'p.uf_natural AS uf_naturalidade',
                'p.naturalidade AS naturalidade',
                'p.nacionalidade AS nacionalidade',
                'p.sexo AS id_sexo',
                'p.email AS email',
                'p.ddd AS ddd',
                'p.celular AS celular',
                'p.cpf AS cpf',
                'tp_sexo.tipo AS nome_sexo',
                'tp_nacionalidade.local AS nome_nacionalidade',
                'tp_uf.sigla AS sigla_naturalidade',
                'tp_cidade.descricao AS descricao_cidade',
                'tp_orgao_exp.sigla AS sigla_orgao_expedidor',
                'tp_ddd.descricao AS numero_ddd',
            )
            ->where('p.id', $idp)
            ->get();


        $funcionario = DB::table('funcionarios AS f')
            ->leftJoin('tp_programa', 'f.tp_programa', 'tp_programa.id')
            ->leftJoin('tp_cor_pele', 'f.id_cor_pele', 'tp_cor_pele.id')
            ->leftJoin('tp_sangue', 'f.id_tp_sangue', 'tp_sangue.id')
            ->leftJoin('tp_fator', 'f.fator_rh', 'tp_fator.id')
            ->leftJoin('tp_uf', 'f.uf_ctps', 'tp_uf.id')
            ->leftJoin('tp_cnh', 'f.id_cat_cnh', 'tp_cnh.id')
            ->leftJoin('setor', 'f.id_setor', 'setor.id')
            ->select(
                'f.matricula AS matricula',
                'f.ctps AS ctps',
                'f.uf_ctps AS uf_ctps',
                'f.serie AS serie_ctps',
                'f.dt_emissao_ctps AS emissao_ctps',
                'f.tp_programa AS tp_programa',
                'f.nr_programa AS nr_programa',
                'f.reservista AS reservista',
                'f.id_cat_cnh AS id_tp_cnh',
                'f.id_cor_pele AS tp_cor',
                'f.id_tp_sangue AS tp_sangue',
                'f.nome_mae AS nome_mae',
                'f.nome_pai AS nome_pai',
                'f.fator_rh AS id_fator_rh',
                'f.titulo_eleitor AS titulo_eleitor',
                'f.zona_tit AS zona_titulo',
                'f.secao_tit AS secao_titulo',
                'f.dt_titulo AS dt_titulo',
                'f.id_setor AS id_setor',
                'f.dt_inicio AS dt_inicio',
                'tp_programa.programa AS nome_programa',
                'tp_cor_pele.nome_cor AS nome_cor',
                'tp_sangue.nome_sangue AS nome_sangue',
                'tp_fator.nome_fator AS nome_fator',
                'tp_uf.sigla AS sigla_ctps',
                'tp_cnh.nome_cat AS tp_cnh',
                'setor.nome AS nome_setor'
            )
            ->where('f.id_pessoa', $idp)
            ->get();

        $endereco = DB::table('endereco_pessoas AS ep')
            ->leftJoin('tp_cidade', 'ep.id_cidade', 'tp_cidade.id_cidade')
            ->leftJoin('tp_uf', 'ep.id_uf_end', 'tp_uf.id')
            ->select(
                'ep.cep AS cep',
                'ep.id_uf_end AS uf_endereco',
                'ep.id_cidade AS cidade',
                'ep.logradouro AS logradouro',
                'ep.numero AS numero',
                'ep.bairro AS bairro',
                'ep.complemento AS complemento',
                'tp_cidade.descricao AS nome_cidade',
                'tp_uf.sigla AS sigla_uf_endereco',
            )
            ->where('id_pessoa', $idp)
            ->get();

        //dd($pessoa, $funcionario, $endereco);
        //Join com a tabela endereco
        $tp_ufe = DB::select('select id, sigla from tp_uf');

        // Joins com a tabela pessoa
        $tpsexo = DB::table('tp_sexo')->select('id', 'tipo')->get();
        $tpnacionalidade = DB::table('tp_nacionalidade')->select('id', 'local')->get();
        $tp_uf = DB::select('select id, sigla from tp_uf');
        $tporg_exp = DB::select('select id, sigla from tp_orgao_exp');
        $tpddd = DB::table('tp_ddd')->select('id', 'descricao')->get();
        $tpcidade = DB::table('tp_cidade')->select('id_cidade', 'descricao')->get();
        $tp_ufi = DB::select('select id, sigla from tp_uf');


        // Joins com a tabela funcionario
        $tpprograma = DB::table('tp_programa')->select('id', 'programa')->get();
        $tppele = DB::table('tp_cor_pele')->select('id', 'nome_cor')->get();
        $tpsangue = DB::table('tp_sangue')->select('id', 'nome_sangue')->get();
        $fator = DB::select('select id, nome_fator from tp_fator');
        $tp_uff = DB::select('select id, sigla from tp_uf');
        $tpcnh = DB::table('tp_cnh')->select('id', 'nome_cat')->get();
        $tpsetor = DB::table('setor')->select('id', 'nome')->get();



        return view('/funcionarios/visualizar-funcionario', compact('identidade', 'pessoa', 'funcionario', 'endereco', 'tpsangue', 'tpsexo', 'tpnacionalidade', 'tppele', 'tpddd', 'tp_uf', 'tpcnh', 'tpcidade', 'tpprograma', 'tpsetor', 'tporg_exp', 'fator', 'tp_uff', 'tp_ufi', 'tp_ufe'));
    }

    public function inativar($idf, Request $request)
    {
        //dd($request->all(), $idf);
        DB::table('acordo AS a')
            ->leftJoin('funcionarios AS f', 'f.id', 'a.id_funcionario')
            ->where('a.id_funcionario', $idf)
            ->whereNull('a.dt_fim')
            ->update([
                'a.dt_fim' => $request->input('dt_fim_inativacao'),
                'a.motivo' => $request->input('motivo_inativar')
            ]);


        app('flasher')->addSuccess('O cadastro do funcionário foi inativado com Sucesso.');
        return redirect()->action([GerenciarFuncionarioController::class, 'index']);
    }
}
