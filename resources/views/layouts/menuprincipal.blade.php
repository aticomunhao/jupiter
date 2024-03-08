<div id="app">
    <nav class="navbar navbar-dark navbar-expand-md navbar-light shadow-sm" style="background-color: #355089;">
        <div class="container">
            <a class="navbar-brand" style="font-weight:bold; font-size: 28px; color:#ffffff;" href="../">Júpiter</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkdropdown"
                aria-controls="navbarNavDarkdropdown" aria-expanded="false" aria-label="Toggle navigation" style="border:none; color:#3d5b9c;">
                <span class="navbar-toggler-icon" style="color:"></span>
            </button>
            <div class=" navbar-collapse" id="navbarNavDarkdropdown">
                <ul class="navbar-nav" >
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

                            <li><a class="dropdown-item" href="/gerenciar-entidades-de-ensino">Gerenciar Entidades de Ensino</a>
                            <li><a class="dropdown-item" href="/gerenciar-setor">Gerenciar Setores</a></li>
                            <li><a class="dropdown-item" href="/gerenciar-hierarquia">Gerenciar Hierarquia</a></li>
                            <!--<li><a href="/gerenciar-cargos-regulares" class="dropdown-item">Gerenciar Cargos Regulares</a></li>
                       // <li><a href="/gerenciar-funcao-gratificada"class="dropdown-item">Gerenciar Funcao Gratificada</a></li> -->
                            <li><a href="/gerenciar-tipo-desconto" class="dropdown-item">Gerenciar Tipo de Desconto</a>
                            </li>
                            <li><a href="{{ route('gerenciar.cargos') }}" class="dropdown-item">Gerenciar Cargos</a>
                            </li>
                            <li><a class="dropdown-item" href="/gerenciar-efetivo">Gerenciar Efetivo</a></li>

                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" style="color:#ffffff;">Direitos
                            Remuneratórios</a>
                        <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkdropdownMenuLink">
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
                            <a id="navbardropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbardropdown">
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
