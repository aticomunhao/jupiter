@extends('layouts.app')

@section('content')
    <br>
    <div class="container-fluid">
        <div class="card">
            <h5 class="card-header">
                <span style="color: blue"> Cadastrar Cargo</span>
            </h5>
            <div class="card-body">
                <form action="{{ route('ArmazenarBaseSalarial', ['idf' => $idf]) }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="row d-flex justify-content-between">
                            <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                                <thead style="text-align: center;">
                                    <th class="col-3">Tipo de Cargo</th>
                                    <th class="col-1">Confirmação</th>
                                    <th class="col">Cargo</th>
                                </thead>

                                <tbody>

                                    <tr id="linha1">
                                        <td>
                                            Cargo Regular
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input checkbox" type="checkbox" value="1"
                                                    id="1">


                                        </td>
                                        <td>

                                        </td>


                                    </tr>
                                    <tr id="linha2">
                                        <td>
                                            Função Gratificada
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input checkbox" type="checkbox" value="2"
                                                    id="2">


                                        </td>
                                        <td>

                                        </td>


                                    </tr>
                                    <tr id="linha">
                                        <td>
                                            Cargo De Confiança
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input checkbox" type="checkbox" value="3"
                                                    id="3">


                                        </td>
                                        <td>

                                        </td>


                                    </tr>
                                    <tr id="linha1">
                                        <td>
                                            Jovem Aprendiz
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input checkbox" type="checkbox" value="4"
                                                    id="4">


                                        </td>
                                        <td>

                                        </td>


                                    </tr>

                                </tbody>

                            </table>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.checkbox').change(function(e) {
                var checkbox = $(this).val();

                if (checkbox == 1) {

                } else if (checkbox == 2) {
                    alert("Checkbox é 2");
                } else if (checkbox == 3) {
                    alert("Checkbox é 3");
                } else {
                    alert("Checkbox não é 1, 2 ou 3");
                }
            });
        });
    </script>
@endsection
