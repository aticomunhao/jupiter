@extends('layouts.app')
@section('head')
    <title>Afastamento funcionários</title>
@endsection
@section('content')

    <div class="container-fluid">
        <h4 class="card-title" style="font-size:20px; text-align: left; color: gray; font-family: calibri">
            RELATÓRIO DE AFASTAMENTOS
        </h4>
        <br>
        <form action="{{route('rel.afast')}}" method="GET">
            <div class="row align-items-center" style="font-size: 12px;">
                 <div class="col-12">
                    <div class="row">
                        <!-- Data de Início -->
                        <div class="col-lg-2 col-6">
                            <label for="dt_inicio" class="form-label">Data de Início</label>
                            <input type="date" class="form-control" id="dt_inicio" name="dt_inicio"  value="{{ $dt_inicio }}">
                        </div>
                        <!-- Data de Fim -->
                        <div class="col-lg-2 col-6">
                            <label for="dt_fim" class="form-label">Data de Fim</label>
                            <input type="date" class="form-control" id="dt_fim" name="dt_fim" value="{{ $dt_fim }}">
                        </div>
                        <!-- Setor -->
                        <div class="col-sm-2 col-sm-2">
                            <label for="setor" class="form-label">Setor:</label>
                            <select class="form-select select2" id="setor" name="setor" data-width="100%">
                                <option value="0">Todos</option>
                                @foreach ($setores as $setor)
                                    <option value="{{ $setor->id }}" {{ $setor->id == request('setor') ? 'selected' : '' }}>
                                        {{ $setor->sigla }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Funcionário -->
                        <div class="col-sm-2 col-sm-2">
                            <label for="grupo" class="form-label">Funcionário:</label>
                            <select class="form-select select2" id="func" name="func"  data-width="100%">
                                    <option value="">Todos</option>
                                @foreach ($func as $fu)
                                    <option value="{{ $fu->id }}" {{ request('func') == (string) $fu->id ? 'selected' : '' }}>
                                        {{$fu->nome_completo}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Tratamento -->
                        <div class="col-sm-2 col-sm-2">
                            <label for="tratamento" class="form-label">Motivos:</label>
                            <select class="form-select select2" id="tratamento" name="motivo" data-width="100%">
                                <option value="0">Todos</option>
                                @foreach ($motivo as $mtv)
                                    <option value="{{ $mtv->id }}" {{ request('motivo') == $mtv->id ? 'selected' : '' }}>
                                        {{ $mtv->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Botão Pesquisar -->
                        <div class="col-lg-1 col-6">
                            <button type="submit" class="btn btn-primary w-100"
                                style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin-top: 27px;">
                                Pesquisar
                            </button>
                        </div>
                        <!-- Botão Limpar -->
                        <div class="col-lg-1 col-6">
                            <a href="/situacao-afastamentos">
                                <button type="button" class="btn btn-warning w-100"
                                    style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; margin-top: 27px;">
                                    Limpar
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br />
        <div class="card">
            <div class="col">
                <span class="text-warning" style="font-size: 20px; margin-left:20px;">&#9632;</span>
                <span style="font-size: 14px;">Sem data fim</span>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                    <thead style="text-align: center; font-size: 12px; color: #000000;">
                        <tr>
                            <th class="col">SETOR</th>
                            <th class="col">FUNCIONÁRIO</th>
                            <th class="col">CONTRATO</th>
                            <th class="col">DATA CONTRATO</th>
                            <th class="col">MOTIVO</th>
                            <th class="col">COMPLEMENTO</th>
                            <th class="col">AFASTADO EM</th>
                            <th class="col">TEMPO AFASTADO</th>
                            <th class="col">RETORNO EM</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 11px; color: #000000; text-align: center;">
                        @foreach ($motafastamento as $mot)
                            <tr>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}">{{ $mot->sigla }} </td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}">{{ $mot->nome_completo }} </td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}">{{ $mot->matricula }} </td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}">{{ \Carbon\Carbon::parse($mot->minicio)->format('d-m-Y')  }} </td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}" >{{ $mot->motafas }} </td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}"> {{$mot->compnome}} </td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}">{{ \Carbon\Carbon::parse($mot->afinicio)->format('d-m-Y') }} </td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}">{{ $mot->anos }} anos, {{ $mot->meses }} meses e {{ $mot->dias }} dias</td>
                                <td style="{{ !$mot->afim ? 'background-color: #FFFF61;' : '' }}">{{  empty($mot->afim) ? '-' : \Carbon\Carbon::parse($mot->afim)->format('d-m-Y')  }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
