<!DOCTYPE html>
<html>

<head>
  <style>
    table,
    td,
    th {
      border: 1px solid black;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .tabe {
      width: 50%;
      font-size: 12px;
      text-align: right;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      border: 2px solid #025E73;
    }

    td {
      text-align: center;
    }

    p {
      margin: 5px;
      text-align: justify;
      line-height: 150%;
      
    }

    .assinatura {
      text-align: center;

    }

    .autorizacao {
      text-align: center;
      font-size: 15px;
    }

    .data {
      text-align: center;
    }
  </style>
</head>

<body>


  <table>
    <tr>
      <th class="tabe">
        <img src="https://pbs.twimg.com/profile_images/1371837828754251786/aBHwD_Zs_400x400.jpg" alt="logo">

        <p>COMUNHAO ESPÍRITA DE BRASÍLIA</p>
        <p>Diretoria Administrativa e Financeira - DAF</p>
      </th>
      <th class="tabe">
        <p class="autorizacao">AUTORIZAÇÃO PARA DÉBITO EM<br> CONTA CORRENTE - BANCO DO BRASIL</p>
      </th>

  </table>
  <br>
  <table>
    <th>
      <p> Eu, <span style="text-decoration: underline;">{{$associado->nome_completo}}</span> portador (a) da Carteira de Identidade nº <span style="text-decoration: underline;">{{$associado->idt}}</span> e CPF <span style="text-decoration: underline;">{{$associado->cpf}}</span>, residente em <span style="text-decoration: underline;">{{$associado->descricao}}, {{$associado->bairro}}, {{$associado->numero}}</span> CEP <span style="text-decoration: underline;">{{$associado->cep}}</span> telefone <span style="text-decoration: underline;">{{$associado->celular}}</span> e e-mail <span style="text-decoration: underline;">{{$associado->email}}</span> AUTORIZO a Comunhão Espírita de Brasília a efetuar mensalmente, no dia <span style="text-decoration: underline;">{{substr($associado->dt_vencimento, -2)}}</span>, débito em minha Agência nº ______________________ Conta Corrente nº _______________________ do Banco do Brasil S.A., o valor da R$<span style="text-decoration: underline;">{{ substr($associado->valor, strpos($associado->valor, '-') + 1) }}</span> referente ao pagamento de mensalidade na qualidade de associado nº<span style="text-decoration: underline;">{{$associado->nr_associado}}</span> da Comunhão Espírita de Brasília.</p>
      @php
      $meses = [
      1 => 'Janeiro',
      2 => 'Fevereiro',
      3 => 'Março',
      4 => 'Abril',
      5 => 'Maio',
      6 => 'Junho',
      7 => 'Julho',
      8 => 'Agosto',
      9 => 'Setembro',
      10 => 'Outubro',
      11 => 'Novembro',
      12 => 'Dezembro'
      ];
      $mesAtual = intval(date('n'));
      @endphp

      <p class="data"> Brasília, <span style="text-decoration: underline;">{{ date('d') }}</span> de <span style="text-decoration: underline;">{{ $meses[$mesAtual] }}</span> de <span style="text-decoration: underline;">{{ date('Y') }}</span></p>


      <br>
      <p class="assinatura">_______________________________________________________</p>
      <br>
    </th>
  </table>
</body>

</html>