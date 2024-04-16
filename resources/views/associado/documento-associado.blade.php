<!DOCTYPE html>
<html>
  <head>
    <style>
      table,
      td,
      th {
        border: 2px solid black;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
      }

      .tabe {
        font-size: 12px;
        text-align: left;
      }

      table {
        border-collapse: collapse;
        width: 100%;
        border: 2px solid #025e73;
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
      .h8 {
        text-align: center;
      }
    </style>
  </head>

  <body>
    <table>
      <th>
        <h7>
          - FICHA DE CADASTRO DE ASSOCIADO CONTRIBUINTE DA COMUNHÃO ESPÍRITA DE
          BRASÍLIA -</h7
        >
      </th>
    </table>
    <table>
      <tr>
        <th class="tabe">
          <p>Nome: {{$associado->nome_completo}}</p>
        </th>
        <th class="tabe">
        <p>CPF: {{$associado->cpf}}</p>
        </th>
      </tr>
    </table>
    <table>
    <tr>
      <th class="tabe">
        <p>Endereço: {{$associado->numero}}</p>
      </th>
      <th class="tabe">
      <p>Cidade: {{$associado->bairro}}</p>
      </th>
      <th class="tabe">
      <p>UF: {{$associado->descricao}}</p>
      </th>
    </tr>
  </table>
  <table>
  <tr>
    <th class="tabe">
      <p>CEP: {{$associado->descricao}}</p>
    </th>
    <th class="tabe">
    <p>TELEFONE(S): {{$associado->celular}}</p>
    </th>
    <th class="tabe">
    <p>E-MAIL: {{$associado->email}}</p>
    </th>
  </tr>
</table>
<table>
<tr>
  <th class="tabe">
    <p>VALOR DA CONTRIBUIÇÃO: R$: {{$associado->descricao}}</p>
  </th>
  <th class="tabe">
  <h9>FORMAS(S) DE CONTRIBUIÇÃO:</h9>
  <p>1)TESOURARIA: ({{$associado->dinheiro}})Dinheiro - ()Cheque - ()Cartão de Débito - ()Cartão de Crédito.</p>
  <p>2)BOLETO BANCÁRIO: ()Mensal - ()Trimestral - ()Semestral - ()Anual</p>
  <p>3)AUTORIZAÇÃO DE DÉBITO EM CONTA ()Banco do Brasil - ()BRB</p>
  </th>
</tr>
</table>
<table>
<tr>
  <th class="tabe">
    <p>DIA DE VENCIMENTO:{{$associado->dt_vencimento}}</p>
  </th>
  <th class="tabe">
  <p>REQUERIMENTO DE ISENÇÃO: ()Deferindo - () Indeferido</p>
  </th>
</tr>
</table>
<table>
<tr>
  <th class="tabe">
    <p>CEP: {{$associado->descricao}}</p>
  </th>
  <th class="tabe">
  <p>TELEFONE(S): {{$associado->celular}}</p>
  </th>
  <th class="tabe">
  <p>E-MAIL: {{$associado->email}}</p>
  </th>
</tr>
</table>
    <br />
    <table>
      <th>
        <p>
          Eu,
          <span style="text-decoration: underline"
            >{{$associado->nome_completo}}</span
          >
          portador (a) da Carteira de Identidade nº
          <span style="text-decoration: underline">{{$associado->idt}}</span> e
          CPF
          <span style="text-decoration: underline">{{$associado->cpf}}</span>,
          residente em
          <span style="text-decoration: underline"
            >{{$associado->descricao}}, {{$associado->bairro}},
            {{$associado->numero}}</span
          >
          CEP
          <span style="text-decoration: underline">{{$associado->cep}}</span>
          telefone
          <span style="text-decoration: underline"
            >{{$associado->celular}}</span
          >
          e e-mail
          <span style="text-decoration: underline">{{$associado->email}}</span>
          AUTORIZO a Comunhão Espírita de Brasília a efetuar mensalmente, no dia
          <span style="text-decoration: underline"
            >{{substr($associado->dt_vencimento, -2)}}</span
          >, débito em minha Agência nº
          <span style="text-decoration: underline"></span> Conta Corrente nº
          <span style="text-decoration: underline"></span> do Banco do Brasil
          S.A., o valor da R$<span style="text-decoration: underline"
            >{{ $associado->valor }}</span
          >
          referente ao pagamento de mensalidade na qualidade de associado
          nº<span style="text-decoration: underline"
            >{{$associado->nr_associado}}</span
          >
          da Comunhão Espírita de Brasília.
        </p>
        @php $meses = [ 1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 =>
        'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 =>
        'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro' ];
        $mesAtual = intval(date('n')); @endphp

        <p class="data">
          Brasília,
          <span style="text-decoration: underline">{{ date('d') }}</span> de
          <span style="text-decoration: underline"
            >{{ $meses[$mesAtual] }}</span
          >
          de <span style="text-decoration: underline">{{ date('Y') }}</span>
        </p>

        <br />
        <p class="assinatura">
          _______________________________________________________
        </p>
        <br />
      </th>
    </table>
  </body>
</html>
