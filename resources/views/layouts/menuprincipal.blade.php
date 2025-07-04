<?php
$acesso = session()->get('usuario.acesso');
$setor = session()->get('usuario.setor');
$perfis = session()->get('usuario.perfis');
// dd(session());
// dd($perfis);
?>


<nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #355089;">
    <div class="container">
        <a class="navbar-brand" style="font-weight:bold; font-size: 28px; color:#ffffff;"
            href="{{ url('/login/valida') }}">Júpiter</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
            aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            @if (in_array(1, $perfis) or
                    in_array(2, $perfis) or
                    in_array(3, $perfis) or
                    in_array(4, $perfis) or
                    in_array(5, $perfis) or
                    in_array(6, $perfis))
                <ul class="navbar-nav" id="1">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="a" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Área de Pessoal</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="/gerenciar-funcionario">Gerenciar Funcionarios</a>
                            </li>
                            <li><a class="dropdown-item" href="/gerenciar-associado">Gerenciar Associados</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
            @if (in_array(1, $perfis) or
                    in_array(2, $perfis) or
                    in_array(3, $perfis) or
                    in_array(4, $perfis) or
                    in_array(5, $perfis) or
                    in_array(6, $perfis))
                <ul class="navbar-nav" id="2">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="b" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Gerenciar</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a href="{{ route('gerenciar.cargos') }}" class="dropdown-item">Cargo dos
                                    Funcionários</a>
                            </li>
                            <li><a class="dropdown-item" href="/gerenciar-entidades-de-ensino">Entidades de Ensino</a>
                            </li>
                            <li><a class="dropdown-item" href="/gerenciar-setor"> Setores</a>
                            </li>
                            <li><a class="dropdown-item" href="/gerenciar-hierarquia">Hierarquia de Setores</a>
                            </li>
                            <li><a class="dropdown-item" href="/controle-vagas">Vagas por Setor</a>
                            </li>
                            <li><a href="{{ route('index.tipos-de-contrato') }}" class="dropdown-item">Tipos de
                                    Contrato</a>
                            </li>
                            <li><a href="/gerenciar-tipo-desconto" class="dropdown-item"> Tipos de Desconto</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
            <ul class="navbar-nav" id="3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="c" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Direitos
                        Remuneratórios</a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        @if (in_array(7, $perfis ?? []))
                            <li><a href="{{ route('IndexGerenciarFerias') }}" class="dropdown-item">Período de
                                    Férias</a>
                            </li>
                        @endif
                        @if (in_array(3, $perfis ?? []))
                            <li><a href="{{ route('AdministrarFerias') }}" class="dropdown-item">Gerenciar Férias</a>
                            </li>
                        @endif
                        @if (in_array(3, $perfis ?? []) or in_array(3, $perfis ?? []))
                            <li><a href="{{ route('index.gerenciar-dia-limite-ferias') }}" class="dropdown-item">Dias
                                    limite para as Férias </a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
            @if (in_array(1, $perfis ?? []) or in_array(6, $perfis ?? []) or in_array(4, $perfis ?? []))
                <ul class="navbar-nav" id="4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="d" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Relatórios</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            @if (in_array(15, $acesso))
                                <li><a class="dropdown-item" href="/gerenciar-efetivo">Controle de Efetivo</a>
                                </li>
                            @endif
                            @if (in_array(18, $acesso))
                                <li><a class="dropdown-item" href="/controle-ferias">Controle de Férias</a>
                                </li>
                            @endif
                            @if (in_array(18, $acesso))
                                <li><a href="/gerenciar-contribuicao" class="dropdown-item">Relatório Contribuição</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            @endif
            @if (in_array(1, $perfis ?? []))
                <ul class="navbar-nav" id="5">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="e" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Administrar
                            Sistema</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a href="/gerenciar-usuario" class="dropdown-item">Gerenciar Usuários</a>
                            </li>
                            <li><a href="/gerenciar-setor-usuario" class="dropdown-item">Gerenciar Setor Usuários</a>
                            </li>
                            <li><a href="/gerenciar-perfis" class="dropdown-item">Gerenciar Perfis </a>
                            </li>
                            <li><a href="/gerenciar-descontos" class="dropdown-item">Gerenciar Descontos </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
            <ul class="navbar-nav" id="6">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="f" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" style="color: #ffffff">Logout</a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="/usuario/alterar-senha"><i
                                    class="mdi mdi-lock-open-outline font-size-17 text-muted align-middle mr-1"></i>Alterar
                                Senha</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void();"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="mdi mdi-power font-size-17 text-muted align-middle mr-1 text-danger"></i>
                                {{ __('Sair') }}</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div>
        <div class=" fst-italic align-middle d-flex d-none d-lg-block justify-d-content-end" style="color:white">
            {{-- DB::table('versoes_venus')->where('dt_fim', null)->first()->versao --}}
        </div>
    </div>
</nav>
