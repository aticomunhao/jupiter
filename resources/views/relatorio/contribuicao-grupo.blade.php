@extends('layouts.app')

@section('title')
    Relatório de Contribições por grupo
@endsection

@section('content')
<div class="container-fluid">
    <h4 class="card-title" style="font-size:20px; text-align: left; color: gray; font-family: calibri">
        RELATÓRIO DE CONTRIBUIÇÕES
    </h4>
    <form method="GET">
        <div class="row justify-content-md-center">
            <div class="col-md-2 col-sm-12">
                <label for="setor" class="form-label">Setor</label>
                <select class="form-select select2" id="setor" name="setor">
                    <option value="">Todos</option>
                    @foreach ($setor as $setores)
                        <option value="{{ $setores->sid }}" {{ request('setor') == $setores->sid ? 'selected' : '' }}>
                            {{ $setores->sigla }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="reuniao" class="form-label">Reunião</label>
                <select class="form-select select2" id="" name="reuniao">
                    <option value="">Todos</option>
                    @foreach ($grupo as $reuniao)
                        <option value="{{ $reuniao->cid }}" {{ request('reuniao') == $reuniao->cid ? 'selected' : '' }}>
                            {{ $reuniao->g_nome }} ({{ $reuniao->s_sigla }}) | {{ $reuniao->d_sigla }} | {{ $reuniao->h_inicio }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="membro" class="form-label">Trabalhador</label>
                <select class="form-select select2" id="membro" name="membro">
                    <option value="">Todos</option>
                    @foreach ($membro as $mem)
                        <option value="{{ $mem->pid }}" {{ request('membro') == $mem->pid ? 'selected' : '' }}>
                            {{ $mem->nome_completo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label for="ano" class="form-label">Ano</label>
                <input type="text" name="anoFiltro" id="anoFiltro" class="form-control" value="{{ request('anoFiltro', date('Y'))  }}" placeholder="Ex: Ano com 4 digitos">
            </div>
            <div class="col-md-2 col-sm-12">
                <input class="btn btn-light btn-sm me-md-2" type="submit" formaction="{{ route('rel.contr')}}" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000;" value="Pesquisar">
                <a href="{{ url()->current() }}" class="btn btn-light btn-sm" style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000;">Limpar</a>
                <input class="btn btn-info" type="submit" formaction="{{route('pdf.contribuicao')}}" value="Gerar PDF" style="box-shadow: 1px 2px 5px #000000; margin:5px;">
            </div>
        </div>
    </form>
    <hr />

    {{-- Paginação por setor --}}
    <h4 class="text-primary">Ano: {{ $anoFiltro }}</h4>
    @forelse($paginatedResult as $setorSigla => $sectorData)
        <h5 class="text-success ms-3">Setor: {{ $setorSigla }}</h5>

        {{-- Acordeão de reuniões por setor --}}
        <div class="accordion mb-4" id="{{ $sectorData['container_id'] }}">
            @foreach($sectorData['reunions'] as $reuniaoData)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $reuniaoData['key'] }}">
                        <button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $reuniaoData['key'] }}"
                            aria-expanded="false"
                            aria-controls="collapse{{ $reuniaoData['key'] }}">
                            Reunião: {{ $reuniaoData['display_name'] }}
                        </button>
                    </h2>

                    <div id="collapse{{ $reuniaoData['key'] }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $reuniaoData['key'] }}"
                        data-bs-parent="#{{ $sectorData['container_id'] }}">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="text-align:left;">
                                                Membros: {{ count($reuniaoData['members'] ?? []) }}
                                            </th>
                                            @foreach(['01'=>'Jan','02'=>'Fev','03'=>'Mar','04'=>'Abr','05'=>'Mai','06'=>'Jun','07'=>'Jul','08'=>'Ago','09'=>'Set','10'=>'Out','11'=>'Nov','12'=>'Dez'] as $num => $nome)
                                                <th style="text-align:center;">{{ $nome }}</th>
                                            @endforeach
                                            <th style="text-align:center;">Total Ano</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reuniaoData['members'] as $trab)
                                            <tr>
                                                <td>
                                                    {{ $trab['nome_completo'] }}
                                                    @if($trab['membro_funcao'])
                                                        <small class="text-muted">({{ $trab['membro_funcao'] }})</small>
                                                    @endif
                                                </td>

                                                @php $totalAnoTrabalhador = 0; @endphp

                                                @foreach(['01','02','03','04','05','06','07','08','09','10','11','12'] as $mes)
                                                    @php
                                                        $valor = $trab['contribuicoes'][$anoFiltro][$mes] ?? 0;
                                                        $totalAnoTrabalhador += $valor;
                                                    @endphp
                                                    <td style="text-align:right; {{ $valor == 0 ? 'background-color: yellow;' : '' }}">
                                                        {{ number_format($valor, 2, ',', '.') }}
                                                    </td>
                                                @endforeach

                                                <td style="text-align:right; font-weight:bold;">
                                                    {{ number_format($totalAnoTrabalhador, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="14" class="text-center">
                                                    Nenhum membro com contribuições registradas para esta reunião neste ano.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center">Nenhum dado encontrado para os filtros selecionados.</p>
    @endforelse

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $paginatedResult->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection