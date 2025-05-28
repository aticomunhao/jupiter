@extends('layouts.app')

@section('head')
    <title>Grupo</title>
@endsection

@section('content')
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="accordion" id="accordionExample">
                    @foreach ($contribuicoes_por_associado as $codigo => $associado)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $codigo }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $codigo }}" aria-expanded="false"
                                    aria-controls="collapse{{ $codigo }}">
                                    {{ $associado['Nome'] }} (Código: {{ $codigo }})
                                </button>
                            </h2>
                            <div id="collapse{{ $codigo }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $codigo }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <table class="table table-striped table-bordered border-secondary table-hover align-middle">
                                        <thead style="text-align: center;">
                                            <tr style="background-color: #d6e3ff; font-size:14px; color:#000000">
                                                <th>Ordem Movimento</th>
                                                <th>Preço Total com Desconto</th>
                                                <th>Referencia</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 14px; color:#000000; text-align: center;">
                                            @foreach ($associado['contribuicoes'] as $contribuicao)
                                                <tr>
                                                    <td>{{ $contribuicao['ordemMovimento'] }}</td>
                                                    <td>R$ {{ number_format($contribuicao['Preco_Total_Com_Desconto'], 2, ',', '.') }}</td>
                                                    <td>{{ $contribuicao['nomeProdutoLimpo']}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
