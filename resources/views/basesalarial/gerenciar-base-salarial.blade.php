@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card" style="border-color:#355089">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-5">
                        <div class="card card-sm">
                            <div class="card-body card-sm">
                                <h5 class="card-title">{{ $funcionario->nome_completo }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                    <thead class="align-middle">
                        <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                            <th class="text-center">Nome Cargo</th>
                            <th class="text-center">Salário</th>
                            @if ($salarioatual->fgid != null)
                                <th>Função Gratificada</th>
                                <th>Gratificação</th>
                            @endif
                            <th class="text-center">Anuênio</th>
                            <th class="text-center">Data Inicial</th>
                            <th class="text-center">Data Final</th>
                            <th class="text-center">Salário Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($base_salarial as $base_salariais)
                            <tr>
                                <td class="text-center">{{ $base_salariais->crnome }}</td>
                                <td class="text-center">{{ formatSalary($base_salariais->crsalario) }}</td>
                                @if ($salarioatual->fgid != null)
                                    @if ($base_salariais->fgsalario !== null)
                                        <td class="text-center">{{ $base_salariais->fgnome }}</td>
                                        <td class="text-center">
                                            {{ formatSalary($base_salariais->fgsalario - $base_salariais->crsalario) }}</td>
                                    @else
                                        <td class="text-center">--</td>
                                        <td class="text-center">--</td>
                                    @endif
                                @endif
                                <td class="text-center">{{ $base_salariais->anuenio }} %</td>
                                <td class="text-center">{{ $base_salariais->bsdti }}</td>
                                <td class="text-center">{{ $base_salariais->bsdtf ?? '--' }}</td>
                                <td>{{ isset($base_salariais->fgsalario) ? formatSalary($base_salariais->fgsalario) : formatSalary($base_salariais->crsalario + ($base_salariais->anuenio / 100 * $base_salariais->crsalario)) }}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @php
        function formatSalary($salary)
        {
            return number_format($salary, 2, ',', '.');
        }
    @endphp
@endsection
