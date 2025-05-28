@extends('layouts.app')
@section('head')
    <title>Editar Rotas do Setor</title>
@endsection
@section('content')
    <br />
    <div class="container">
        <div class="card">
            <div class="card-header">
                Editar Rotas do Setor
            </div>
            <div class="card-body">
                <br>
                <div class="row justify-content-start">
                    <form method="POST" action="/atualizar-setor-usuario/{{ $setor->id }}">
                        @csrf
                        <div class="row col-10 offset-1" style="margin-top:none">
                            <div class="col-12">
                                <label>Setor</label>
                                <input type="text" class="form-control" value="{{  $setor->nome }}" disabled>
                            </div>
                            <div class="col-12">
                            <label>Funcionalidades Autorizadas</label>
                            <select class="form-select select2" name="rotas[]" multiple>
                                @foreach ($rotas as $rota)
                                    <option value="{{ $rota->id }}" id="id{{ $rota->id }}">{{ $rota->nome }}</option>
                                @endforeach
                            </select>
                            </div>
                        <center>
                            <div class="col-12" style="margin-top: 50px;">
                                <a href="/gerenciar-setor-usuario" class="btn btn-danger col-3">Cancelar</a>
                                <button type="submit" class="btn btn-primary col-3 offset-3">Confirmar</button>
                            </div>
                        </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Select2 JS -->
   
    <!-- Bootstrap Bundle JS -->
    <script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Seleciona as rotas',
            width: '100%',
            allowClear: true
        });

        let rotasSelecionadas = @json($rotasSelecionadas);

        // Define os valores selecionados diretamente
        $('.select2').val(rotasSelecionadas).trigger('change');
    });
</script>

@endsection
