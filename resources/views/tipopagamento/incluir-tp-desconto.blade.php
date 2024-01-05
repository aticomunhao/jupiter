@extends('layouts.app')

@section('content')
    <br />

    <div class="container">

        <div class="card">

            <div class="card-header">
                Adicionar Tipo de Desconto
            </div>

            <div class="card-body">
                <br>
                <div class="row justify-content-start">

                    
                    <center>
                        <div class="col-10" style="margin-top:none">

                            <input type="text" class="form-control" aria-label="Sizing example input" placeholder="Tipo de desconto...">
                        </div>



                    <center>
                        <div class="col-12">
                            <br />
                            <br />
                            <br />
                                <a href="/gerenciar-tipo-desconto">
                                <button class="btn btn-secondary col-3">Cancelar</button>
                                </a>

                                <a href="/gerenciar-tipo-desconto">
                                <button class="btn btn-success col-3 offset-4">Novo</button>
                                </a>
                        </div>
                    </center>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
