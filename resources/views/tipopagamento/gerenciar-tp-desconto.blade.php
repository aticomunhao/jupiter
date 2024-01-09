@extends('layouts.app')

@section('content')
    <br />
    <div class="container">
        <div class="card" style="border-color:#5C7CB6">
            <div class="card-header">
                Gerenciar Tipo de Desconto
            </div>
            <div class="card-body">
                <div class="row justify-content-start">
                    <div class="col-4">
                        <input type="text" class="form-control" aria-label="Sizing example input">
                    </div>
                    <div class="col-8  d-md-flex justify-content-md-between">
                        <button class="btn btn-secondary col-3">Pesquisar</button>

                        <div class="col-8  offset-6">
                            <a href="/incluir-tipo-desconto">
                                <button class="btn btn-success col-3">Novo</button>
                            </a>
                        </div>
                    </div>
                </div>
                <br />
                <hr>



                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead style="text-align: center; ">
                        <tr style="background-color: #355089; font-size:19px; color:#ffffff;">
                            <th>Tipo de desconto</th>
                            <th>Desconto</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody style="font-size: 15px; color:#000000;">

                    @foreach ($desc as $descrpt)






                            <tr>
                                <td>{{ $descrpt->description }}</td>
                                <td>{{ $descrpt->percDesconto }}</td>
                                <td style="text-align: center;">
                                    <a href="/editar-tipo-desconto/{{ $descrpt->id }}" class="btn btn-warning editDesc">
                                        <i class="bi bi-pencil" style="font-size: ; color:#FFF;"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="bi bi-trash" style="font-size: 1rem; color:#FFF;"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
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
