<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        href="https://getbootstrap.com/docs/5.3/assets/css/docs.css"
        rel="stylesheet"
    />
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /*Coloca as bordas nos TH e TD*/
        th{
            border-radius: 0;
            border: black solid /*Edite este valor de pixels para aumentar ou diminuir a borda*/1px;
            padding-top: 2px;
            padding-right: 10px;
            padding-bottom: 2px;
            padding-left: 10px;
        }
        td{
            border-radius: 0;
            border: black solid /*Edite este valor de pixels para aumentar ou diminuir a borda*/1px;
            padding-top: 2px;
            padding-right: 10px;
            padding-bottom: 2px;
            padding-left: 10px;
        }
        .wdt {
            /*Eite o Width para aumentar o tamanho da tabela. Cada 0.1px correspondem a 1.2px real (0.1 * 12)*/
            width:40px;
            border:none;

        }
        body{
            font-size:15px;
            font-family: "Times New Roman";
        }

    </style>
</head>
<!--
  Este código foi feito e pensado baseado no sistema de GRID do
  Boostrap, substitua os campos: <span style="color:brown">VAR</span>
  por varáveis de valor
-->
<body>

<center>
    <table>

        <tr>
            <!--Setup para funcionamento do GRID, colunas invisíveis-->
            <th class="wdt"></th>
            <th class="wdt"></th>
            <th class="wdt"></th>

            <th class="wdt"></th>
            <th class="wdt"></th>
            <th class="wdt"></th>

            <th class="wdt"></th>
            <th class="wdt"></th>
            <th class="wdt"></th>

            <th class="wdt"></th>
            <th class="wdt"></th>
            <th class="wdt"></th>

        </tr>
        <!--
            Edite os valores COLSPAN para aumentar a coluna no GRID horizontalmente,
            edite ou adicione ROWSPAN para aumentar verticalmente
        -->
        <tr>
            <th colspan="12" style="text-align: center;">FICHA DE CADASTRO DE ASSOCIADO CONTRIBUINTE DA COMUNHÃO ESPÍRITA DE BRASÍLIA</th>
        </tr>

        <tr>
            <td colspan="8">NOME: <span style="color:brown">VAR</span></td>
            <td colspan="4" rowspan="3"><span style="color:brown">VAR</span></td>
        </tr>
        <tr>
            <td colspan="3">CPF: <span style="color:brown">VAR</span></td>
            <td colspan="5">ASSOCIADO Nº <span style="color:brown">VAR</span></td>
        </tr>
        <tr>
            <td colspan="4">TELEFONE: <span style="color:brown">VAR</span></td>
            <td colspan="4">E-MAIL: <span style="color:brown">VAR</span></td>
        </tr>
        <tr>
            <td colspan="2">CEP: <span style="color:brown">VAR</span></td>
            <td colspan="3">CIDADE: <span style="color:brown">VAR</span></td>
            <td colspan="1">UF: <span style="color:brown">VAR</span></td>
            <td colspan="6">ENDEREÇO: <span style="color:brown">VAR</span></td>
        </tr>
        <tr>
            <td colspan="2" rowspan="3" style="text-align: center;">VALOR DA CONTRIBUIÇÃO <span style="text-decoration: underline;"><span style="color:brown">VAR</span></span></td>
            <td colspan="10"><span style="text-decoration: underline;">TESOURARIA:</span> [ <span style="color:brown">VAR</span> ] Dinheiro - [ ] Cheque - [ ] Cartão de Débito - [ ] Cartão de Crédito
            </td>
        </tr>
        <tr>
            <td colspan="10"><span style="text-decoration: underline;">BOLETO BANCÁRIO:</span> [ <span style="color:brown">VAR</span> ] Mensal - [ ] Trimestral - [ ] Semestral - [ ] Anual</td>
        </tr>
        <tr>
            <td colspan="10"><span style="text-decoration: underline;">AUTORIZAÇÃO DE DÉBITO EM CONTA:</span> [ <span style="color:brown">VAR</span> ] Banco do Brasil - [ ] BRB</td>
        </tr>
        <tr>
            <td colspan="4">DIA DE VENCIMENTO: <span style="color:brown">VAR</span></td>
            <td colspan="8"><span style="text-decoration: underline;">REQUERIMENTO DE ISENÇÃO:</span> [ <span style="color:brown">VAR</span> ] Deferido - [ ] Indeferido</td>
        </tr>
        <tr>
            <td colspan="12">

                <p>
                    <span style="font-weight: bold; font-style: italic;">1. </span>A CONTRIBUIÇÃO FEITA POR MEIO DE BOLETO E AUTORIZAÇÃO DE DÉBITO EM CONTA DEVERÁ TER O VALOR
                    MÍNIMO DE R$ 25,00.
                </p>
                <p>
                    <span style="font-weight: bold; font-style: italic;">2. </span>APÓS DEFINIDO O VALOR DA CONTRIBUIÇÃO PELO ASSOCIADO, ESSA IMPORTÂNCIA SERÁ OBRIGATÓRIA (ART. 9º
                    DO ESTATUTO) ATÉ A DATA DE EVENTUAL ALTERAÇÃO DO VALOR. ASSIM, NÃO HAVERÁ ALTERAÇÃO DO VALOR DA
                    CONTRIBUIÇÃO VENCIDA, EXCETO SE AUTORIZADO PELO PRESIDENTE DO CD
                </p>
                <p>
                    <span style="font-weight: bold; font-style: italic;">3. </span>O ASSOCIADO EM DIA COM A CONTRIBUIÇÃO PODERÁ SUSPENDER SUA CONTRIBUIÇÃO IMEDIATAMENTE,
                    MEDIANTE SOLICITAÇÃO À TESOURARIA.
                </p>
                <p>
                    <span style="font-weight: bold; font-style: italic;">4. </span>QUALQUER ALTERAÇÃO DE “VALOR DE CONTRIBUIÇÃO” E/OU DE “DIA DE VENCIMENTO” DEVERÁ SER REQUERIDA
                    NA TESOURARIA
                </p>
                <p>
                    <span style="font-weight: bold; font-style: italic;">5. </span>O ASSOCIADO AUTORIZA A DIRETORIA ADMINISTRATIVA E FINANCEIRA DA COMUNHÃO - DAF A CIENTIFICÁ-LO
                    QUANDO FOR CONSTATADO QUE NÃO HOUVE O REGISTRO DE PAGAMENTO EM SEU SISTEMA, POR MAIS DE 2 (DOIS)
                    MESES.
                </p>
                <p>
                    <span style="font-weight: bold; font-style: italic;">6. </span>O ASSOCIADO DECLARA QUE CUMPRIRÁ O ESTATUTO DA COMUNHÃO, BEM COMO AS NORMAS
                    COMPLEMENTARES DECORRENTES.
                </p>
            </td>
        </tr>
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
        <tr>
            <td colspan="12">
                <p>
                    <br />
                    Autorizo o TRATAMENTO e o ARMAZENAMENTO dos dados acima para uso interno e restrito da COMUNHÃO, para fins de
                    cumprimento de dispositivos estatutários e legais (Art. 5º, incisos XVI! a XX! da CF; Art. 53 a 61 CC; e, Art. 9º ao 11 e 14,
                    inc. V do Estatuto) - Contribuição mensal do Associado
                </p>
                <br />
                <p style="text-align: center;">Brasília, <span style="text-decoration: underline;"><span style="color:brown">VAR</span></span> de <span style="text-decoration: underline;"><span style="color:brown">VAR</span></span> de <span style="text-decoration: underline;"><span style="color:brown">VAR</span></span></p>
                <br />
                <p style="font-weight: bold;text-align: center; margin-bottom:0px">________________________________________________________________</p>
                <p style="font-weight: bold;text-align: center; margin-top:0px;">ASSINATURA DO(A) ASSOCIADO(A)</p>
            </td>
        </tr>








    </table>
</center>

</body>
</html>
