@extends('layouts.app')
@section('head')
    <title>Gerenciar Tipo de Desconto</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#5C7CB6">
            <div class="card-header">
                Gerenciar Tipo de Desconto
            </div>
            <div class="card-body">



                <form method="GET" action="/gerenciar-tipo-desconto">

                    @csrf
                    <div class="row justify-content-start">
                        <div class="col-md-4 col-sm-12">
                            <input type="text" class="form-control" aria-label="Sizing example input" name="pesquisa"
                                value= "{{ $pesquisa }}" maxlength="40">
                        </div>
                        <div class="col-md-8 col-12">

                            <button class="btn btn-secondary col-md-3 col-12 mt-5 mt-md-0 "
                                type="submit">Pesquisar</button>

                            <a href="/incluir-tipo-desconto"
                                class="btn btn-success col-md-3 col-12 offset-md-5 offset-0 mt-2 mt-md-0">
                                Novo+
                            </a>


                        </div>
                    </div>
                </form>
                <br />
                <hr>



                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead style="text-align: center; ">
                        <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                            <th>Tipo de desconto</th>
                            <th>Desconto</th>
                            <th>Data Inicial</th>
                            <th>Data Final</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody style="font-size: 15px; color:#000000;">

                        @foreach ($desc as $descrpt)
                            <tr>

                                <td>{{ $descrpt->description }}</td>
                                <td style="text-align:center;">{{ $descrpt->percDesconto }}%</td>
                                <td style="text-align:center;">{{ $descrpt->dt_inicio }}</td>
                                <td style="text-align:center;">{{ $descrpt->dt_final }}</td>

                                <td style="text-align: center;">
                                    @if ($descrpt->dt_final == null)
                                    <a href="/renovar-tipo-desconto/{{ $descrpt->id }}" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-clockwise"></i></i>
                                    </a>
                                @endif
                                    <a href="/editar-tipo-desconto/{{ $descrpt->id }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $descrpt->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $descrpt->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Excluir</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body ">
                                            Tem certeza que deseja excluir este arquivo?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <a href="/exluir-tipo-desconto/{{ $descrpt->id }}"
                                                class="btn btn-danger">Excluir Permanentemente</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
