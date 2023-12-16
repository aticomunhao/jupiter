@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <br>
        <div class="row flex-row justify-content-around">
            <div class="container-fluid">
                <fieldset class="border rounded">
                    <DIV class="CARD">
                        <div class="card-header">
                            <form action="/gerenciar-funcao-gratificada" method="GET" class="w-100">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <input type="text" class="form-control" placeholder="{{ $search }}"
                                               name="search" style="">
                                    </div>
                                    <br>
                                    <div class="col-lg-2 col-md-12">
                                        <button class="btn btn-light btn-sm"
                                                style="font-size: 0.9rem; box-shadow: 1px 2px 5px #000000; width: 100%;margin-top: 1%"
                                                type="submit">
                                            Pesquisar
                                        </button>
                                    </div>
                                    <div class="col"></div>
                                    <div class="col-lg-3 col-md-12">
                                        <a href="/criar-funcao-gratificada">
                                            <button type="button" class="btn btn-success"
                                                    style="padding: 10px 15%; box-shadow: 4px 3px 2px rgba(0, 0, 0, 0.836); margin-top: 1%; width: 100%;">
                                                Novo &plus;
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <DIV class="CARD-BODY">
                        <div class="container-fluid">
                            <DIV class="CARD-TEXT">
                                <table
                                    class="table table-striped table-bordered border-secondary table-hover align-middle justify-content-center">
                                    <thead class="text-align: justify-center">
                                    <tr style="background-color: #d6e3ff; font-size:17px; color:#343434">
                                        <th class="col-lg-4 col-sm-12">CARGO</th>
                                        <th class="col-lg-2 col-sm-12">SALARIO ATUAL</th>
                                        <th class="col-lg-2 col-sm-12">DATA INICIO</th>
                                        <th class="col-lg-2 col-sm-12">DATA FIM</th>
                                        <th class="col-lg-2 col-sm-12">AÇÕES</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($funcoesgratificadas as $funcoesgratificada)

                                        @if($funcoesgratificada->status == false)
                                            <tr class="text-secondary">
                                                <td class="align-middle text-danger">{{ $funcoesgratificada->nomeFG }}</td>
                                                <td class="align-middle">
                                                    <span
                                                        class="text-danger"> R&dollar; {{ $funcoesgratificada->salarioFG }}</span>
                                                </td>
                                                <td class="align-middle text-danger">{{ \Carbon\Carbon::parse($funcoesgratificada->dt_inicioFG)->format('d/m/Y') }}</td>
                                                @if($funcoesgratificada->dt_fimFG != null)
                                                    <td class="align-middle text-danger">{{ \Carbon\Carbon::parse($funcoesgratificada->dt_fimFG)->format('d/m/Y') }}</td>
                                                @elseif($funcoesgratificada->dt_fimFG == null)
                                                    <td class="align-middle text-danger">EM VIGOR</td>
                                                @endif
                                                <td class="align-middle">
                                                    <a href="/editar-funcao-gratificada/{{$funcoesgratificada->id}}"
                                                       class="btn btn-outline-primary">
                                                        <i class="bi bi-pencil" style="color: #0F0024"></i>
                                                    </a>
                                                    <a href="/historico-cargo-regular/" class="btn btn-outline-info">
                                                        <i class="bi bi-search" style="color: #0F0024"></i>
                                                    </a>
                                                    <a href="/fechar-funcao-gratificada/{{$funcoesgratificada->id}}"
                                                       class="btn btn-outline-danger  bg-gradient text-dark">
                                                        <i class="bi bi-x-circle" style="color: #0F0024"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                        @else
                                            <tr>
                                                <td style="vertical-align: middle;">{{ $funcoesgratificada->nomeFG }}</td>
                                                <td style="vertical-align: middle;">
                                                    R&dollar; {{ $funcoesgratificada->salarioFG }}</td>
                                                <td style="vertical-align: middle;">{{ \Carbon\Carbon::parse($funcoesgratificada->dt_inicioFG)->format('d/m/Y') }}</td>
                                                @if($funcoesgratificada->dt_fimFG != null)
                                                    <td>{{ \Carbon\Carbon::parse($funcoesgratificada->dt_fimFG)->format('d/m/Y') }}</td>
                                                @elseif($funcoesgratificada->dt_fimFG == null)
                                                    <td style="vertical-align: middle;">EM VIGOR</td>
                                                @endif
                                                <td class="align-middle">
                                                    <a href="/editar-funcao-gratificada/{{$funcoesgratificada->id}}"
                                                       class="btn btn-outline-primary">
                                                        <i class="bi bi-pencil" style="color: #0F0024"></i>
                                                    </a>
                                                    <a href="/historico-cargo-regular/" class="btn btn-outline-info">
                                                        <i class="bi bi-search" style="color: #0F0024"></i>
                                                    </a>
                                                    <a href="/fechar-funcao-gratificada/{{$funcoesgratificada->id}}"
                                                       class="btn btn-outline-danger">
                                                        <i class="bi bi-x-circle" style="color: #0F0024"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif

                                    @endforeach
                                    </tbody>
                                </table>
                            </DIV>
                        </div>
                    </DIV>
            </div>
        </div>
    </DIV>
    </fieldset>
    </div>
    </div>
@endsection


