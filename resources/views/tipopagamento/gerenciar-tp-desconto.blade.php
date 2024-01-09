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
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 15px; color:#000000;">
                        @foreach ($desc as $descrpt)
                            <tr>
                                <td>{{ $descrpt->nome }}</td>
                                <td style="text-align: center;">
                                    <a href="/editar-tipo-desconto/{{ $descrpt->id }}" class="btn btn-warning editDesc" style="hover{ color: }">
                                        <i class="bi bi-pencil" style="font-size: ; color:#FFF;"></i>
                                    </a>
                                    <a href="" class="btn btn-danger">
                                        <i class="bi bi-trash" style="font-size: 1rem; color:#FFF;"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
