
<div id="app">
    <nav class="navbar navbar-dark navbar-expand-md navbar-light shadow-sm" style="background-color: #355089;">
        <div class="container">
            <a class="navbar-brand" style="font-weight:bold; font-size: 28px; color:#ffffff;"
               href="{{ route('home.post') }}">Júpiter</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDarkdropdown"
                    aria-controls="navbarNavDarkdropdown" aria-expanded="false" aria-label="Toggle navigation"
                    style="border:none; color:#3d5b9c;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class=" navbar-collapse" id="navbarNavDarkdropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="1" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Área de Pessoal</a>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkdropdownMenuLink">
                            <li><a class="dropdown-item" href="/gerenciar-funcionario">Gerenciar Funcionarios</a></li>
                            <li><a class="dropdown-item" href="gerenciar-voluntario">Gerenciar Voluntários</a></li>
                            <li><a class="dropdown-item" href="/gerenciar-associado">Gerenciar Associados</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="2" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Gerenciar</a>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkdropdownMenuLink">

                            <li><a class="dropdown-item" href="/gerenciar-entidades-de-ensino">Gerenciar Entidades de
                                    Ensino</a>
                            <li><a class="dropdown-item" href="/gerenciar-setor">Gerenciar Setores</a></li>
                            <li><a class="dropdown-item" href="/gerenciar-hierarquia">Gerenciar Hierarquia</a></li>
                            <!--<li><a href="/gerenciar-cargos-regulares" class="dropdown-item">Gerenciar Cargos Regulares</a></li>
                       // <li><a href="/gerenciar-funcao-gratificada"class="dropdown-item">Gerenciar Funcao Gratificada</a></li> -->
                            <li><a href="/gerenciar-tipo-desconto" class="dropdown-item">Gerenciar Tipo de Desconto</a>
                            </li>

                            <li><a href="{{ route('gerenciar.cargos') }}" class="dropdown-item">Gerenciar Cargos</a>
                            </li>
                            <li><a href="{{ route('index.tipos-de-acordo') }}" class="dropdown-item">Gerenciar Tipo de Acordo</a>
                            </li>

                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="2" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Direitos
                            Remuneratórios</a>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkdropdownMenuLink">
                            <li><a href="{{ route('IndexGerenciarFerias') }}" class="dropdown-item">Período de
                                    Férias</a>
                            </li>
                            <li><a href="{{ route('AdministrarFerias') }}" class="dropdown-item">Gerenciar Férias</a>
                            </li>
                            <li><a href="{{ route('index.gerenciar-dia-limite-ferias') }}" class="dropdown-item">Dias
                                    limite para as Férias </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="1" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Relatórios</a>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkdropdownMenuLink">
                            <li><a class="dropdown-item" href="/gerenciar-efetivo">Controle de Efetivo</a></li>
                            <li><a class="dropdown-item" href="/controle-vagas">Controle de Vagas</a></li>
                            <li><a class="dropdown-item" href="/controle-ferias">Controle de Férias</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="1" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Administrar
                            Sistema</a>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkdropdownMenuLink">
                            <li><a href="/gerenciar-usuario" class="dropdown-item">Gerenciar Usuários</a>
                            </li>
                            <li><a href="/gerenciar-setor-usuario" class="dropdown-item">Gerenciar Setor Usuários</a>
                            </li>
                            <li><a href="/gerenciar-perfis" class="dropdown-item">Gerenciar Perfis </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="4" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false" style="color: #ffffff">Logout</a>
                        <ul class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="/usuario/alterar-senha"><i
                                        class="mdi mdi-lock-open-outline font-size-17 text-muted align-middle mr-1"></i>Alterar
                                    Senha</a></li>
                            <li><a class="dropdown-item" href="javascript:void();"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="mdi mdi-power font-size-17 text-muted align-middle mr-1 text-danger"></i>
                                    {{ __('Sair') }}</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
