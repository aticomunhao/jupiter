@extends('layouts.app')
@section('head')
    <title>Editar Setor</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card">
            <div class="card-header">
                Editar Setor
            </div>
            <div class="card-body">
                <br>
                <div class="row justify-content-start">
                    <form method="POST" action="/atualizar-setor-usuario/{{ $setor->id }}">
                        @csrf
                        <div class="row col-10 offset-1" style="margin-top:none">
                            <div class="col-12">
                                Setor
                                <select class="form-select select2" name="setor">
                                    @foreach ($setores as $st)
                                        <option value="{{ $st->id }}" {{ $setor->id == $st->id ? 'selected' : '' }}>
                                            {{ $st->nome }}</option>
                                    @endforeach
                                </select>
                                <br />
                            </div>
                            <div class="col-12">
                                Funcionalidades Autorizadas
                                <select class="form-select select2" name="rotas[]" multiple>
                                    @foreach ($rotas as $rota)
                                        <option value="{{ $rota->id }}" id="id{{ $rota->id }}">{{ $rota->nome }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>


                            <center>
                                <div class="col-12" style="margin-top: 50px;">
                                    <a href="/gerenciar-setor-usuario" class="btn btn-danger col-3">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary col-3 offset-3">
                                        Confirmar
                                    </button>
                                </div>
                            </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Select2 JS -->
   
    <!-- Bootstrap Bundle JS -->
    

    <script>
        window.rotasSelecionadas = @json($rotasSelecionadas);
    </script>
@endsection
