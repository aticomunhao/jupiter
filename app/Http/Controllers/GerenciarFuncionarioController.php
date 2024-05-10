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

class GerenciarFuncionarioController extends Controller
{


    public function index(Request $request)
    {

        $lista = DB::table('funcionarios AS f')
            ->leftjoin('pessoas AS p', 'f.id_pessoa', 'p.id')
            ->select('f.id AS idf', 'p.cpf', 'p.idt', 'p.nome_completo', 'p.status', 'p.id AS idp');

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

        if ($request->status) {
            $lista->where('p.status', '=', $request->status);
        }

        if ($request->nome) {
            $lista->where('p.nome_completo', 'LIKE', '%' . $request->nome . '%');
        }

        $lista = $lista->orderBy('p.status', 'asc')->orderBy('p.nome_completo', 'asc')->paginate(10);


        return view('/funcionarios.gerenciar-funcionario', compact('lista', 'cpf', 'idt', 'status', 'nome'));
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

        //dd($vercpf);

        try {
            $validated = $request->validate([
                //'telefone' => 'required|telefone',
                'cpf' => 'required|cpf',
                //'cnpj' => 'required|cnpj',
                // outras validações aqui
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            app('flasher')->addError('Este CPF não é válido');
            return redirect()->back()->withInput();
            //dd($e->errors());
        }

        if ($exists) {

            app('flasher')->addError('Existe outro cadastro usando este número de CPF');
            return redirect()->back()->withInput();
        } elseif ($vercpf) {

            DB::table('pessoas')
                ->where('cpf', $cpf)
                ->update([
                    'nome_completo' => $request->input('nome_completo'),
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
                'status' => '1',

            ]);

            $id_pessoa = DB::table('pessoas')
                ->select(DB::raw('MAX(id) as max_id'))
                ->value('max_id');


            DB::table('funcionarios')->insert([
                'dt_inicio' => $request->input('dt_ini'),
                'id_pessoa' => $id_pessoa,
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

            DB::table('endereco_pessoas')->insert([
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
        ->select(
            'ep.cep AS cep',
            'ep.id_uf_end AS uf_endereco',
            'ep.id_cidade AS cidade',
            'ep.logradouro AS logradouro',
            'ep.numero AS numero',
            'ep.bairro AS bairro',
            'ep.complemento AS complemento'
        )
        ->where('id_pessoa', $idp)
        ->get();

        //dd($pessoa, $funcionario);


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




    /*    $editar = DB::table('funcionarios AS f')
            ->leftjoin('pessoas AS p', 'f.id_pessoa', 'p.id')
            ->leftjoin('tp_sangue', 'tp_sangue.id', 'f.id_tp_sangue')
            ->leftjoin('tp_programa', 'tp_programa.id', 'f.tp_programa')
            ->leftjoin('tp_sexo', 'tp_sexo.id', 'p.sexo')
            ->leftjoin('tp_nacionalidade AS tn', 'tn.id', 'p.nacionalidade')
            ->leftjoin('tp_cor_pele', 'tp_cor_pele.id', 'f.id_cor_pele')
            ->leftjoin('tp_ddd', 'tp_ddd.id', 'p.ddd')
            ->leftjoin('tp_orgao_exp', 'tp_orgao_exp.id', 'p.orgao_expedidor')
            ->leftjoin('tp_uf', 'tp_uf.id', 'p.uf_natural')
            ->leftjoin('tp_cidade AS tc', 'tc.id_cidade', 'p.naturalidade')
            ->leftjoin('tp_cnh AS tpcnh', 'tpcnh.id', 'f.id_cat_cnh')
            ->leftjoin('setor AS s', 's.id', 'f.id_setor')
            ->leftJoin('endereco_pessoas AS endp', 'p.id', '=', 'endp.id_pessoa')
            ->leftjoin('tp_fator', 'tp_fator.id', 'f.fator_rh')
            ->select(
                'f.id_pessoa AS idp',
                'f.id AS idf',
                'p.nome_completo',
                'f.matricula',
                'f.titulo_eleitor',
                'f.zona_tit',
                'f.secao_tit',
                'f.dt_titulo',
                'f.dt_inicio',
                'p.celular',
                'f.dt_emissao_ctps',
                'f.ctps',
                'f.serie',
                'f.uf_ctps',
                'f.reservista',
                'f.nome_pai',
                'f.nome_mae',
                'p.email',
                'f.id_cat_cnh',
                'tpcnh.id AS tpcn',
                'tpcnh.nome_cat AS nmcnh',
                'p.orgao_expedidor',
                'p.cpf',
                'p.idt',
                'p.dt_emissao_idt',
                'p.nacionalidade',
                'tp_sangue.id',
                'p.dt_nascimento',
                'tp_sangue.id AS tpsang',
                'tp_sangue.nome_sangue AS nmsangue',
                'tp_sexo.id AS id_tps',
                'tp_sexo.tipo AS tps',
                'tp_programa.id AS tpprog',
                'tp_programa.programa AS prog',
                'tn.id AS tpnac',
                'tn.local AS tnl',
                'tp_cor_pele.id AS tpcor',
                'tp_cor_pele.nome_cor AS nmpele',
                'tp_ddd.id AS tpd',
                'tp_ddd.descricao AS dddesc',
                'tp_uf.id AS tuf',
                'tp_uf.sigla AS ufsgl',
                'p.uf_natural',
                'p.uf_idt AS ufIdt',
                'p.naturalidade',
                'tc.id_cidade',
                'tc.descricao AS nat',
                'f.id_setor',
                's.id AS ids',
                's.nome AS setnome',
                'endp.cep',
                'endp.logradouro',
                'endp.numero',
                'endp.bairro',
                'endp.complemento',
                'tp_orgao_exp.sigla AS orgexp_sigla',
                'tp_fator.nome_fator',
                'tp_fator.id AS idFator'

            )
            ->where('f.id_pessoa', $idp)
            ->get();

        //dd($editar);

*/




        //dd($tpsetor);


        return view('/funcionarios/editar-funcionario', compact('identidade', 'pessoa', 'funcionario', 'endereco', 'tpsangue', 'tpsexo', 'tpnacionalidade', 'tppele', 'tpddd', 'tp_uf', 'tpcnh', 'tpcidade', 'tpprograma', 'tpsetor', 'tporg_exp', 'fator', 'tp_uff', 'tp_ufi'));
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

            return redirect()->action([GerenciarFuncionarioController::class, 'index']);

    }

    public function delete($idp)
    {

        $funcionario = DB::table('funcionarios')->select('funcionarios.id AS idf')->where('id_pessoa', $idp)->first();

        $dependentes = DB::select('select * from dependentes');

        foreach ($dependentes as $dependente) {

            if ($funcionario->idf == $dependente->id_funcionario) {
                app('flasher')->addWarning("Não foi possivel excluir o funcionario, pois o dependente  de nome $dependente->nome_dependente esta cadastrado");
                return redirect()->action([GerenciarFuncionarioController::class, 'index']);
            }
        }

        $certficado = DB::select('select * from certificados');

        foreach ($certficado as $certificados) {

            if ($funcionario->idf == $certificados->id_funcionario) {
                app('flasher')->addWarning("Não foi possivel excluir o funcionario, pois possui certificado cadastrado com o nome de $certificados->nome");
                return redirect()->action([GerenciarFuncionarioController::class, 'index']);
            }
        }


        $dados_bancario = DB::select('select * from dados_bancarios');


        foreach ($dados_bancario as $dados_bancarios) {
            if ($funcionario->id_pessoa == $dados_bancarios->id_pessoa) {

                app('flasher')->addWarning("Não foi possivel excluir o funcionario, pois o dependente  de nome $dependente->nome_dependente esta cadastrado");
            }
        }


        DB::table('funcionarios')->where('id_pessoa', $idp)->delete();


        app('flasher')->addSuccess('O cadastro do funcionario foi Removido com Sucesso.');
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
}
