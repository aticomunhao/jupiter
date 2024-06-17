<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function index()
    {
        try {
            return view('login/login');
        } catch (\Exception $e) {

            $code = $e->getCode();
            return view('login/login erro.erro-inesperado', compact('code'));
        }
    }

    public function valida(Request $request)
    {
        try {
            $cpf = $request->input('cpf');
            $senha = $request->input('senha');

            $result = DB::select("
            SELECT
                u.id AS id_usuario,
                p.id AS id_pessoa,
                a.id AS id_associado,
                p.cpf,
                p.sexo,
                p.nome_completo,
                u.hash_senha,
                STRING_AGG(DISTINCT u_p.id_tp_perfil::text, ',') AS perfis,
                STRING_AGG(DISTINCT u_d.id_deposito::text, ',') AS depositos,
                STRING_AGG(DISTINCT u_s.id_setor::text, ',') AS setores
            FROM usuario u
            LEFT JOIN pessoas p ON u.id_pessoa = p.id
            LEFT JOIN associado a ON a.id_pessoa = p.id
            LEFT JOIN tp_usuario_perfil u_p ON u.id = u_p.id_usuario
            LEFT JOIN usuario_deposito u_d ON u.id = u_d.id_usuario
            LEFT JOIN tp_usuario_setor u_s ON u.id = u_s.id_usuario
            WHERE u.ativo IS TRUE AND p.cpf = ?
            GROUP BY u.id, p.id, a.id
        ", [$cpf]);

            if (count($result) === 0) {
                app('flasher')->addError('Credenciais inválidas');
                return view('login/login');
            }

            $user = $result[0];
            if (!Hash::check($senha, $user->hash_senha)) {
                app('flasher')->addError('Credenciais inválidas');
                return view('login/login');
            }

            $perfis = explode(',', $user->perfis);
            $setores = explode(',', $user->setores);

            $rotasPerfis = DB::table('tp_rotas_perfil')
                ->whereIn('id_perfil', $perfis)
                ->orderBy('id_rotas')
                ->pluck('id_rotas')
                ->toArray();

            $rotasSetores = DB::table('rotas_setor')
                ->whereIn('id_setor', $setores)
                ->orderBy('id_rotas')
                ->pluck('id_rotas')
                ->toArray();

            $rotasAutorizadas = array_intersect($rotasPerfis, $rotasSetores);

            session()->put('usuario', [
                'id_usuario' => $user->id_usuario,
                'id_pessoa' => $user->id_pessoa,
                'id_associado' => $user->id_associado,
                'nome' => $user->nome_completo,
                'cpf' => $user->cpf,
                'sexo' => $user->sexo,
                'setor' => $setores,
                'acesso' => $rotasAutorizadas,
            ]);

            app('flasher')->addSuccess('Acesso autorizado');
            return view('login/home');
        } catch (\Exception $exception) {
            app('flasher')->addError("Você não possui perfis para acesso");
            return redirect()->back();
        }
    }

    public function validaUserLogado()
    {
        try {
            $cpf = session()->get('usuario.cpf');

            $result = DB::select("
        select
        u.id id_usuario,
        p.id id_pessoa,
        p.cpf,
        p.sexo,
        p.nome_completo,
        u.hash_senha,
        string_agg(distinct u_p.id_tp_perfil::text, ',') perfis,
        string_agg(distinct u_d.id_deposito::text, ',') depositos,
        string_agg(distinct u_s.id_setor::text, ',') setor
        from usuario u
        left join pessoas p on u.id_pessoa = p.id
        left join tp_usuario_perfil u_p on u.id = u_p.id_usuario
        left join usuario_deposito u_d on u.id = u_d.id_usuario
        left join tp_usuario_setor u_s on u.id = u_s.id_usuario
        where u.ativo is true and p.cpf = '$cpf'
        group by u.id, p.id
        ");

            $perfis = explode(',', $result[0]->perfis);
            $setores = explode(',', $result[0]->setor);
            $array_setores = $setores;

            $perfis = DB::table('tp_rotas_perfil')->whereIn('id_perfil', $perfis)->orderBy('id_rotas')->pluck('id_rotas');
            $setores = DB::table('rotas_setor')->whereIn('id_setor', $setores)->orderBy('id_rotas')->pluck('id_rotas');

            $perfis = json_decode(json_encode($perfis), true);
            $setores = json_decode(json_encode($setores), true);

            $rotasAutorizadas = array_intersect($perfis, $setores);

            if ($cpf = session()->get('usuario.cpf')) {
                session()->put('usuario', [
                    'id_usuario' => $result[0]->id_usuario,
                    'id_pessoa' => $result[0]->id_pessoa,
                    'nome' => $result[0]->nome_completo,
                    'cpf' => $result[0]->cpf,
                    'sexo' => $result[0]->sexo,
                    'setor' => $array_setores,
                    'acesso' => $rotasAutorizadas,
                ]);
                return view('/login/home');
            } else {
                return view('login/login')->with('Error', 'O Sr(a) deve informar as credenciais para acessar o sistema');
            }
        } catch (\Exception $e) {

            $code = $e->getCode();
            return view('tratamento-erro.erro-inesperado', compact('code'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    //
}
