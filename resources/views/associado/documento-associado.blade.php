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
        line-height: 100%;
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
  <p>4)REQUERIMENTO DE ISENÇÃO: ()Deferindo - () Indeferido</p>
  </th>
</tr>
</table>
    <table>
      <th>
        <p>
          OBSERVAÇÕES:
          <br>

          1) A CONTRIBUIÇÃO FEITA POR MEIO DE BOLETO E AUTORIZAÇÃO DE DÉBITO EM CONTA DEVERÁ TER O VALOR MÍNIMO DE R$ 25,00.
          <br>
          2) APÓS DEFINIDO O VALOR DA CONTRIBUIÇÃO PELO ASSOCIADO, ESSA IMPORTÂNCIA SERÁ OBRIGATÓRIA (ART. 9º DO ESTATUTO) ATÉ A DATA DE EVENTUAL
          ALTERAÇÃO DO VALOR. ASSIM, NÃO HAVERÁ ALTERAÇÃO DO VALOR DA CONTRIBUIÇÃO VENCIDA, EXCETO SE AUTORIZADO PELO PRESIDENTE DO CD.
          <br>
          3) O ASSOCIADO EM DIA COM A CONTRIBUIÇÃO PODERÁ SUSPENDER SUA CONTRIBUIÇÃO IMEDIATAMENTE, MEDIANTE SOLICITAÇÃO À TESOURARIA.
          <br>
          4) QUALQUER ALTERAÇÃO DE “VALOR DE CONTRIBUIÇÃO” E/OU DE “DIA DE VENCIMENTO” DEVERÁ SER REQUERIDA NA TESOURARIA.
          <br>
          5) O ASSOCIADO AUTORIZA A DIRETORIA ADMINISTRATIVA E FINANCEIRA DA COMUNHÃO - DAF A CIENTIFICÁ-LO QUANDO FOR CONSTATADO QUE NÃO HOUVE
          O REGISTRO DE PAGAMENTO EM SEU SISTEMA, POR MAIS DE 2 (DOIS) MESES.
          <br>
          6) O ASSOCIADO DECLARA QUE CUMPRIRÁ O ESTATUTO DA COMUNHÃO, BEM COMO AS NORMAS COMPLEMENTARES DECORRENTES.      
        </p>

  
      </th>
    </table>
    <table>
      <th>
        <p>Autorizo o TRATAMENTO e o ARMAZENAMENTO dos dados acima para uso interno e restrito da COMUNHÃO, para fins de cumprimento de dispositivos
estatutários e legais (Art. 5º, incisos XVI! a XX! da CF; Art. 53 a 61 CC; e, Art. 9º ao 11 e 14, inc. V do Estatuto) - Contribuição mensal do Associado.
</p><br>
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
      <p style="text-left:10px;">ASSINATURA DO(A) ASSOCIADO(A)__________________________________________</p>

      </th>
    </table>
  </body>
</html>
