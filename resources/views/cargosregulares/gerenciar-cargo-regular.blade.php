@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <br>
        <div class="row flex-row justify-content-around">
            <div class="container-fluid">

                <fieldset class="border rounded">
                    <DIV class="CARD">

                            <div class="card-header">
                                <form action="/gerenciar-cargos-regulares" method="GET" class="w-100">
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
                                            <a href="/criar-cargo-regular">
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
                                            @foreach ($cargosregulares as $cargoregular)
                                                <tr>
                                                    @if ($cargoregular->nomeCR != null)
                                                        <td style="vertical-align: middle;">{{ $cargoregular->nomeCR }}</td>
                                                    @elseif($cargoregular->nomeCC != null)
                                                        <td style="vertical-align: middle;">{{ $cargoregular->nomeCC }}</td>
                                                    @endif
                                                    <td style="vertical-align: middle;">
                                                        R&dollar; {{ $cargoregular->salariobase }}</td>
                                                    <td style="vertical-align: middle;">
                                                        {{ \Carbon\Carbon::parse($cargoregular->dt_inicioCR)->format('d/m/Y') }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ \Carbon\Carbon::parse($cargoregular->dt_fimCR)->format('d/m/Y') }}
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        <a
                                                            href="
                                                                    /editar-cargo-regular/{{ $cargoregular->id }}">
                                                            <button class="btn btn-outline-primary"><span
                                                                    style="color: #000000; text-decoration: none"><i
                                                                        class="bi bi-pencil"></i></span>
                                                            </button>
                                                        </a>
                                                        <a
                                                            href="
                                                                    /historico-cargo-regular/{{ $cargoregular->id }}">
                                                            <button class="btn btn-outline-info">
                                                                <span style="color: #000;text-decoration: none"><i
                                                                        class="bi bi-search"></i></span>
                                                            </button>
                                                        </a>
                                                        </button>
                                                    </td>
                                                </tr>
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
