<div id="app">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #355089;">
        <div class="container">
            <a class="navbar-brand" style="font-weight:bold; font-size: 28px; color:#ffffff;" href="../">Júpiter</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" data-bs-target="#navbarNavDarkDropdown"
                aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
            </button>
            <div class="navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="1" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Área de Pessoal</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
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
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">

                            <li><a class="dropdown-item" href="/gerenciar-entidades-de-ensino">Gerenciar Entidades de Ensino</a>
                            <li><a class="dropdown-item" href="/gerenciar-setor">Gerenciar Setores</a></li>
                            <li><a class="dropdown-item" href="/gerenciar-hierarquia">Gerenciar Hierarquia</a></li>
                            <!--<li><a href="/gerenciar-cargos-regulares" class="dropdown-item">Gerenciar Cargos Regulares</a></li>
                       // <li><a href="/gerenciar-funcao-gratificada"class="dropdown-item">Gerenciar Funcao Gratificada</a></li> -->
                            <li><a href="/gerenciar-tipo-desconto" class="dropdown-item">Gerenciar Tipo de Desconto</a>
                            </li>
                            <li><a href="{{ route('gerenciar.cargos') }}" class="dropdown-item">Gerenciar Cargos</a>
                            </li>

                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Direitos
                            Remuneratórios</a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a href="{{ route('IndexGerenciarFerias') }}" class="dropdown-item">Gerenciar Ferias</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" style="color:#ffffff;"
                                    href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        {{--
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" style="color:#ffffff;" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
