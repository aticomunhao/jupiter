@extends('layouts.app')

@section('head')
    <title>Visualizar Funcionário</title>
@endsection

@section('content')
    @csrf
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <br>
                <div class="card" style="border-color: #355089;">
                    <div class="card-header">
                        <div class="ROW">
                            <h5 class="col-12" style="color: #355089">
                                Visualizar Dados Pessoais
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-header">
                                                Nome Completo
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">{{ $pessoa[0]->nome_completo }}</li>
                                            </ul>
                                        </div>
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-header">
                                                Nome Resumido
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">{{ $pessoa[0]->nome_resumido }}</li>
                                            </ul>
                                        </div>

                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">Nome Completo:</span>
                                                    {{ $pessoa[0]->nome_completo }}
                                                    <span style="font-weight: bold;">Nome resumido:</span>
                                                    {{ $pessoa[0]->nome_resumido }}
                                                    <span style="font-weight: bold;">CPF:</span> {{ $pessoa[0]->cpf }}
                                                    <span style="font-weight: bold;">Data de Nascimento:</span>
                                                    {{ $pessoa[0]->dt_nascimento }}
                                                    <span style="font-weight: bold;">Sexo:</span>
                                                    {{ $pessoa[0]->nome_sexo }}
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">Nacionalidade:</span>
                                                    {{ $pessoa[0]->nome_nacionalidade }}
                                                    <span style="font-weight: bold;">UF de Nascimento:</span>
                                                    {{ $pessoa[0]->sigla_naturalidade }}
                                                    <span style="font-weight: bold;">Naturalidade:</span>
                                                    {{ $pessoa[0]->descricao_cidade }}
                                                    <span style="font-weight: bold;">Número de Identidade:</span>
                                                    {{ $pessoa[0]->identidade }}
                                                    <span style="font-weight: bold;">UF da Identidade:</span>
                                                    {{ $identidade[0]->sigla_identidade }} <br>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">Órgão Expedidor:</span>
                                                    {{ $pessoa[0]->sigla_orgao_expedidor }}
                                                    <span style="font-weight: bold;">Data de Emissão:</span>
                                                    {{ $pessoa[0]->dt_emissao_identidade }}
                                                    <span style="font-weight: bold;">Email:</span> {{ $pessoa[0]->email }}
                                                    <span style="font-weight: bold;">DDD:</span>
                                                    {{ $pessoa[0]->numero_ddd }}
                                                    <span style="font-weight: bold;">Telefone/Celular:</span>
                                                    {{ $pessoa[0]->celular }} <br>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">Número da Matrícula:</span>
                                                    {{ $funcionario[0]->matricula }}
                                                    <span style="font-weight: bold;"> Data de Ingresso:
                                                    </span>{{ $funcionario[0]->dt_inicio }}
                                                    <span style="font-weight: bold;"> Setor Alocado:</span>
                                                    {{ $funcionario[0]->nome_setor }}
                                                    <span style="font-weight: bold;"> CTPS:</span>
                                                    {{ $funcionario[0]->ctps }}
                                                    <span style="font-weight: bold;">Série:</span>
                                                    {{ $funcionario[0]->serie_ctps }}
                                                    <span style="font-weight: bold;">UF do CTPS:</span>
                                                    {{ $funcionario[0]->sigla_ctps }}
                                                    <span style="font-weight: bold;">Data de Emissão:</span>
                                                    {{ $funcionario[0]->emissao_ctps }} <br>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">Titulo Eleitor:</span>
                                                    {{ $funcionario[0]->titulo_eleitor }}
                                                    <span style="font-weight: bold;">Zona:</span>
                                                    {{ $funcionario[0]->zona_titulo }}
                                                    <span style="font-weight: bold;">Seção:</span>
                                                    {{ $funcionario[0]->secao_titulo }}
                                                    <span style="font-weight: bold;">Data de Emissão:</span>
                                                    {{ $funcionario[0]->dt_titulo }}
                                                    <span style="font-weight: bold;">Tipo Programa:</span>
                                                    {{ $funcionario[0]->nome_programa }}
                                                    <span style="font-weight: bold;">Número do PIS ou PASEP:</span>
                                                    {{ $funcionario[0]->nr_programa }} <br>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">Cor Pele:</span>
                                                    {{ $funcionario[0]->nome_cor }}
                                                    <span style="font-weight: bold;">Ascendente 1:</span>
                                                    {{ $funcionario[0]->nome_mae }}
                                                    <span style="font-weight: bold;">Ascendente 2:</span>
                                                    {{ $funcionario[0]->nome_pai }}
                                                    <span style="font-weight: bold;">Número de Reservista:</span>
                                                    {{ $funcionario[0]->reservista }}
                                                    <span style="font-weight: bold;">Cat CNH:</span>
                                                    {{ $funcionario[0]->tp_cnh }}
                                                    <span style="font-weight: bold;">Tipo Sanguíneo:</span>
                                                    {{ $funcionario[0]->nome_sangue }}
                                                    <span style="font-weight: bold;">Fator RH:</span>
                                                    {{ $funcionario[0]->nome_fator }} <br>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">CEP:</span> {{ $endereco[0]->cep }}
                                                    <span style="font-weight: bold;"> UF:</span>
                                                    {{ $endereco[0]->sigla_uf_endereco }}
                                                    <span style="font-weight: bold;">Cidade:</span>
                                                    {{ $endereco[0]->nome_cidade }}
                                                    <span style="font-weight: bold;">Logradouro:</span>
                                                    {{ $endereco[0]->logradouro }} <br>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card" style="border-color: #355089">
                                            <div class="row">
                                                <div class="col-md">
                                                    <span style="font-weight: bold;">Número:</span>
                                                    {{ $endereco[0]->numero }}
                                                    <span style="font-weight: bold;">Complemento:</span>
                                                    {{ $endereco[0]->complemento }}
                                                    <span style="font-weight: bold;">Bairro:</span>
                                                    {{ $endereco[0]->bairro }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row d-flex justify-content-around">
                <div class="col-4">
                    <a href="{{ route('gerenciar') }}">
                        <button class="btn btn-primary" style="width: 100%;">Retornar</button>
                    </a>
                </div>
            </div>
            <br>
        @endsection
