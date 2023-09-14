@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    <div class="container">
        <div class="justify-content-center">
            <div class="col-12">
                <br>
                <div class="card">
                    <fieldset class="border rounded border-primary">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6"><span
                                        style=" color: rgb(26, 53, 173); font-size:15px;">Gerenciar-Dependentes</span>
                                </div>
                                <div class="col-6">
=======
            <br>
            <div class="container">
                <div class="justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">Editar-Dependentes
                                    </div>
                                    <div class="col-6">
                                    </div>
>>>>>>> main
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body bg-body-secondary">
                                            <div style="color: rgb(26, 53, 173); font-size:15px;">
                                                {{ $funcionario[0]->nome_completo }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-1">

                                    <div class="row">
                                        <span style="margin-top: 15px; margin-left: -18px"><a
                                                href="/incluir-dependentes/{{ $funcionario[0]->id }}"><button type="button"
                                                    class="btn btn-success btn-sm"
                                                    style="padding: 5px 80px;margin-right:100px">Novo&plus;</button></a></span>
                                    </div>
                                </div>
                                <div class="col-2"></div>
                            </div>
                            <hr>
                            <div class="table">
                                <table
                                    class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                                    <thead style="text-align: center;">
                                        <tr style="background-color: #d6e3ff; font-size:17px; color:#000000">
                                            <th class="col-2">Parentesco</th>
                                            <th class="col-4">Nome</th>
                                            <th class="col-2">Data de Nascimento</th>
                                            <th class="col-2">CPF</th>
                                            <th class="col-3">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-size: 14px; color:#000000;">
                                        <tr>
                                            @foreach ($dependentes as $dependente)
                                                {{-- witch($dependente->id_pessoa)
                                            @case(1)
                                                Pai
                                                @break
                                            @case(2)
                                                Mãe
                                                @break
                                            @case(3)
                                                Filha
                                            @break
                                            @case(4)
                                                Filho
                                            @break
                                            @default
                                        @endswitch</td> --}}
                                                <td scope="">{{ $dependente->nome }}</td>
                                                <td scope="">{{ $dependente->nome_dependente }}</td>
                                                <td scope="">{{ $dependente->dt_nascimento }}</td>
                                                <td scope="">{{ $dependente->cpf }}</td>
                                                <td scope="">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger delete-btn btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#A{{ $dependente->dt_nascimento }}-{{ $dependente->id }}"><i
                                                            class="bi bi-trash"></i></button>


                                                    <!-- Modal -->

                                                    <div class="modal fade"
                                                        id="A{{ $dependente->dt_nascimento }}-{{ $dependente->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <div class="row">
                                                                        <h2>Excluir Dependente</h2>
                                                                    </div>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="fw-bold alert alert-danger text-center">Voce
                                                                        realmente deseja
                                                                        <br>
                                                                        <span class="fw-bolder fs-5">EXCLUIR
                                                                            {{ $dependente->nome_dependente }}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancelar</button>
                                                                    <a href="/deletar-dependentes/{{ $dependente->id }}"><button
                                                                            type="button"
                                                                            class="btn btn-danger">Excluir</button></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!--Fim Modal-->


                                                    <a href="/editar-dependentes/{{ $dependente->id }}"><button
                                                            type="submit" class="btn btn-primary btn-sm"><i
                                                                class="bi bi-pencil btn-sm"></i></button></a>
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
@endsection
