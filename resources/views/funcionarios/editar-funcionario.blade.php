@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        </div>
    </div>
    <legend style="color:rgb(16, 19, 241); width:-20%; "></legend>
    <fieldset class="border rounded border-primary p-2">
<div>
    <form method = 'POST' action = "/atualizar-funcionario/{{$editar[0]->idf}}{{$editar[0]->idp}}">

      @csrf


  <div class="form-group row" style = "display:flex;
    justify-content:space-between; width: 100%;">
    <div class="form-group col-md-2">
      <label for="validationCustom01">Matricula</label>
      <input class="form-control" name= "matricula" value ="{{$editar[0]->matricula}}" >
      <div class="invalid-feedback">
        Por favor, informe o Número da Matrícula.
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="validationCustom02">Nome Completo</label>
      <input type="text" class="form-control" name = "nome_completo" value ="{{$editar[0]->nome_completo}}" >
    </div>
    <br>
    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Nascimento</label>
      <input type="date" class="form-control" name = "dt_nascimento" value ="{{$editar[0]->dt_nascimento}}" >
         <div class="invalid-feedback">
        Por favor, selecione a Data de Nascimento.
    </div>
    </div>
    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Sexo</label>
      <select id="12" class="form-select" name = "sexo" type = "text">
      <option value="{{$editar[0]->id_tps}}">{{$editar[0]->tps}}</option>
        @foreach ($tpsexo as $tpsexos)
        <option value= "{{$tpsexos->id}}">{{$tpsexos->tipo}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um Campo
    </div>
    </div>

  <div class="form-group row" style = " display:flex;
    justify-content:space-between; width: 100%; ">
    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Nacionalidade</label>
      <select id="12" class="form-select" name = "pais" >
      <option value="{{$editar[0]->tpnac}}">{{$editar[0]->tnl}}</option>
        @foreach ($tpnacionalidade as $tpnacionalidades)
        <option value= "{{$tpnacionalidades->id}}">{{$tpnacionalidades->local}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione uma Nacionalidade.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Naturalidade UF</label>
      <select id="validationCustomUsername" class="form-select" name = "uf_nat" >

         </select>
      <div class="invalid-feedback">
        Por favor, selecione um UF válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Naturalidade-Cidade</label>
      <select id="12" class="form-select"  name = "natura" type="numeric">
      <option  value="{{$editar[0]->id_cidade}}">{{$editar[0]->nat}}</option>
        @foreach ($tpcidade as $tpcidades)
        <option value= "{{$tpcidades->id_cidade}}">{{$tpcidades->descricao}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um UF válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">CPF</label>
      <input type="text" class="form-control" name = "cpf" id="validationCustom05"  value ="{{$editar[0]->cpf}}" >
      <div class="invalid-feedback">
        Por favor, informe um CPF válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">PIS/PASEP</label>
      <select id="12" name = "programa" class="form-select" >
      <option value="{{$editar[0]->tpprog}}">{{$editar[0]->prog}}</option>
        @foreach ($tpprograma as $tpprogramas)
        <option value= "{{$tpprogramas->id}}">{{$tpprogramas->programa}}</option>

        @endforeach
</select>
      <div class="invalid-feedback">
        Por favor, informe um PIS/PASEP válido.
    </div>
    </div>

    <div class="form-group row" style = " display:flex;
    justify-content:space-between; width: 100%; ">

    <div class="form-group col-md-2">
      <label for="validationCustom05">Identidade</label>
      <input type="text" class="form-control" name = "identidade" id="validationCustom05" value ="{{$editar[0]->idt}}">
      <div class="invalid-feedback">
        Por favor, informe um RG válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Orgão Exp</label>
      <input type="text" class="form-control" name = "orgexp" id="validationCustom05" value ="{{$editar[0]->orgao_expedidor}}">
      <div class="invalid-feedback">
        Por favor, informe o Orgão Exp válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" name = "dt_idt" id="validationCustomUsername" value ="{{$editar[0]->dt_emissao_idt}}">
      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Cor Pele</label>
      <select id="12" name = "cor" class="form-select" type = "bigint" >
      <option value="{{$editar[0]->tpcor}}">{{$editar[0]->nmpele}}</option>
        @foreach ($tppele as $tppeles)
        <option value= "{{$tppeles->id}}">{{$tppeles->nome_cor}}</option>

        @endforeach
</select>
      <div class="invalid-feedback">
        Por favor, selecione a Cor da Pele.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Tipo Sanguineo</label>
      <select id="12" name = "tps" class="form-select" >
      <option value="{{$editar[0]->tpsang}}">{{$editar[0]->nmsangue}}</option>
        @foreach ($tpsangue as $tpsangues)
        <option value= "{{$tpsangues->id}}">{{$tpsangues->nome_sangue}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um DDD válido.
    </div>
    </div>

</div>
<div class="form-group row" style = " display:flex;
    justify-content:space-between; width: 100%; ">

    <div class="form-group col-md-2">
      <label for="validationCustom05">Titulo eleitor Nr</label>
      <input type="text" class="form-control" name = "titele" id="validationCustom05" value = "{{$editar[0]->titulo_eleitor}}" >
          <div class="invalid-feedback">
        Por favor, informe um Titulo eleitor Nr válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Zona</label>
      <input type="text" class="form-control" name = "zona" id="validationCustom05" value = "{{$editar[0]->zona_tit}}" >
      <div class="invalid-feedback">
        Por favor, informe um Titulo eleitor Nr válido.
    </div>
    </div>

    <div class="form-group col-md-1">
      <label for="validationCustom05">Seção</label>
      <input type="text" class="form-control" name = "secao" id="validationCustom05" value = "{{$editar[0]->secao_tit}}" >
      <div class="invalid-feedback">
        Por favor, informe uma Seção válida.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" name = "dt_titulo" id="validationCustomUsername" value = "{{$editar[0]->dt_titulo}}">

      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">DDD</label>
      <select id="12" class="form-select" name = "ddd">
      <option value="{{$editar[0]->tpd}}">{{$editar[0]->dddesc}}</option>
        @foreach ($tpddd as $tpddds)
        <option value= "{{$tpddds->id}}">{{$tpddds->descricao}}</option>

      @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um DDD válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Celular</label>
      <input type="text" class="form-control" name = "celular" id="validationCustom05" value = "{{$editar[0]->celular}}"  >
      <div class="invalid-feedback">
        Por favor, informe o Número de Celular.
    </div>
    </div>

    <div class="form-group row" style = " display:flex;
    justify-content:space-between; width: 100%; ">

  <div class="form-group col-md-2">
      <label for="validationCustom05">CTPS Nr</label>
      <input type="text" class="form-control" name = "ctps" id="validationCustom05" value = "{{$editar[0]->ctps}}" >

      <div class="invalid-feedback">
        Por favor, informe um CTPS Nr válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" name = "dt_ctps" id="validationCustomUsername" value = "{{$editar[0]->dt_emissao_ctps}}">

      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Série</label>
      <input type="text" class="form-control" name = "serie_ctps" id="validationCustom05"  value = "{{$editar[0]->serie}}">
           <div class="invalid-feedback">
        Por favor, informe um Nr Série válido.
    </div>
    </div>

    <div class="form-group col-sm-2">
      <label for="validationCustomUsername">UF</label>
      <select id="12" class="form-select" name = "uf_idt" >
      <option value="{{$editar[0]->tuf}}">{{$editar[0]->ufsgl}}</option>
        @foreach ($tpufidt as $tpufidts)
        <option value= "{{$tpufidts->id}}">{{$tpufidts->sigla}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um UF válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Reservista</label>
      <input type="text" class="form-control" name = "reservista" id="validationCustom05" value = "{{$editar[0]->reservista}}">

    </div>
    <div class="form-group row" style = "">

    <div class="form-group col-md-6">
      <label for="validationCustom05">Nome da Mãe</label>
      <input type="text" class="form-control" name = "nome_mae" id="validationCustom05" value = "{{$editar[0]->nome_mae}}" >
      <div class="invalid-feedback">
        Por favor, informe o Nome da Mãe>
    </div>
    <br>
    </div>

    <div class="form-group col-md-6">
      <label for="validationCustom05">Nome do Pai</label>
      <input type="text" class="form-control" name = "nome_pai" id="validationCustom05" value = "{{$editar[0]->nome_pai}}" >
    </div>

  </div>

  <div class="form-group row" style = "">

  <div class="form-group col-md-5">
      <label for="validationCustom05">Email</label>
      <input type="text" class="form-control" name = "email" id="validationCustom05" value = "{{$editar[0]->email}}" >
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Cat CNH</label>
      <select id="validationCustomUsername" class="form-select" name = "cnh" >
        <option value="{{$editar[0]->tpcn}}">{{$editar[0]->nmcnh}}</option>
        @foreach ( $tpcnh as $tpcnhs )
          <option value="{{$tpcnhs->id}}">{{$tpcnhs->nome_cat}}</option>
        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione uma Cat CNH válida.
    </div>
  </div>
</div>
<div>

</div>
</fieldset>
<div class="botões" style = "padding-left:20px;  font-size:40px; width: 50%;">
<a href="/gerenciar-funcionario" type ="button" value = "" class="btn btn-danger">Cancelar</a>
<input type ="submit" value= "Confirmar" class="btn btn-primary">
</form>
</div>
<script>
// Exemplo de JavaScript inicial para desativar envios de formulário, se houver campos inválidos.
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Pega todos os formulários que nós queremos aplicar estilos de validação Bootstrap personalizados.
    var forms = document.getElementsByClassName('needs-validation');
    // Faz um loop neles e evita o envio
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

@endsection
