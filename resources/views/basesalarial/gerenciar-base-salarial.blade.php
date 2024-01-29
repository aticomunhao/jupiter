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
                    <div class="col-4">
                        <a href="{{ route('EditarBaseSalarial', ['idf' => $idf]) }}">
                            <button class="btn btn-primary">Editar Salario Atual</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered border-secondary table-hover align-middle">
                        <thead class="align-middle">
                            <tr style="background-color: #d6e3ff; font-size:19px; color:#000;">
                                <th class="text-center">Nome Cargo</th>
                                <th class="text-center">Salário</th>
                                <th class="text-center">Anuênio</th>
                                @if ($salarioatual->fgid != null)
                                    <th>Função Gratificada</th>
                                    <th>Gratificação</th>
                                @endif
                                <th class="text-center">Data Inicial</th>
                                <th class="text-center">Data Final</th>
                                <th class="text-center">Salário Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($hist_base_salarial as $hist_base_salarials)
                                <tr>
                                    <td class="text-center">{{ $hist_base_salarials->crnome }}</td>
                                    <td class="text-center">{{ formatSalary($hist_base_salarials->crsalario) }}</td>
                                    <td class="text-center">{{ calculaAnuenio($hist_base_salarials, $funcionario) }} %</td>
                                    @if ($salarioatual->fgid != null)
                                        @if ($hist_base_salarials->hist_bs_fg_salario !== null)
                                            <td class="text-center">{{ $hist_base_salarials->fgnome }}</td>
                                            <td class="text-center">
                                                {{ formatSalary($hist_base_salarials->hist_bs_fg_salario - ($hist_base_salarials->hist_bs_cr_salario + ($hist_base_salarials->hist_bs_cr_salario * calculaAnuenio($hist_base_salarials, $funcionario))/100)) }}
                                            </td>
                                        @else
                                            <td class="text-center">--</td>
                                            <td class="text-center">--</td>
                                        @endif
                                    @endif
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($hist_base_salarials->hist_bs_dtinicio)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ optional($hist_base_salarials->hist_bs_dtfim)->format('d/m/Y') ?? '----' }}
                                    </td>
                                    <td>
                                        {{ isset($hist_base_salarials->hist_bs_fg_salario)
                                            ? formatSalary($hist_base_salarials->hist_bs_fg_salario)
                                            : formatSalary(
                                                $hist_base_salarials->crsalario +
                                                    (calculaAnuenio($hist_base_salarials, $funcionario) / 100) * $hist_base_salarials->crsalario,
                                            ) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row d-flex justify-content-around">
                    <div class="col-4">
                        <a href="{{ route('gerenciar') }}">
                            <button class="btn btn-primary" style="width: 100%">Retornar </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    function formatSalary($salary)
    {
        return 'R$' . number_format($salary, 2, ',', '.');
    }

    function calculaAnuenio($hist_base_salarial, $funcionario)
    {
        if ($hist_base_salarial->hist_bs_dtfim == null) {
            $dataDeHoje = \Carbon\Carbon::now();
            $dataDeContratacao = \Carbon\Carbon::parse($funcionario->dt_inicio);
            $calculoFinal = intval($dataDeHoje->diffInDays($dataDeContratacao) / 365);
            return $calculoFinal >= 10 ? 10 : $calculoFinal;
        } else {
            $dataFim = \Carbon\Carbon::parse($hist_base_salarial->hist_bs_dtfim);
            $dataDeContratacao = \Carbon\Carbon::parse($funcionario->dt_inicio);
            return intval($funcionario->dt_inicio->diffInDays($dataDeContratacao) / 365);
        }
    }
@endphp
