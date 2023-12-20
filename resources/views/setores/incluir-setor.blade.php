@extends('layouts.app')


@section('content')
<br>

<div class="container">

    <div class="card">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">
            <div class="row">
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="Nome">
                </div>
                <div class="col-2">
                    <input type="text" class="form-control" placeholder="Sigla">
                </div>
                <br>
                <div class="row">
                <div class="col-6">
                    <input type="select" class="form-control" placeholder="Setor Pai">
                </div>J
                <div class="col-2">
                    <input type="select" class="form-control" placeholder="">
                </div>
            </div>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>




    </div>
</div>

@endsection