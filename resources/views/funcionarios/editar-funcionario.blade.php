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
    <form method = 'POST' action = "atualizar-funcionario/{{$editar[0]->idf}}">
      
      @csrf
   
  <div class="form-group row" style = "display:flex;
    justify-content:space-between; width: 100%;">
    <div class="form-group col-md-2">
      <label for="validationCustom01">Matricula</label>
      <input type="text" class="form-control" value ="{{$editar[0]->matricula}}"  required>
      <div class="invalid-feedback">
        Por favor, informe o Número da Matrícula.
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="validationCustom02">Nome Completo</label>
      <input type="text" class="form-control" value ="{{$editar[0]->nome_completo}}"  required>
    </div>
    <br>
    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Nascimento</label>
      <input type="date" class="form-control" value ="{{$editar[0]->dt_nascimento}}" required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Nascimento.
    </div>
    </div>
    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Sexo</label>
      <select id="12" class="form-select" >
      <option value="{{$editar[0]->id}}">{{$editar[0]->tps}}</option>
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
      <select id="12" class="form-select" >
      <option value="{{$editar[0]->id}}">{{$editar[0]->tnl}}</option>
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
      <select id="validationCustomUsername" class="form-control" >
        <option selected></option>
        <option>Distrito Federal</option>
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um UF válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Naturalidade-Cidade</label>
      <select id="12" class="form-select" type="numeric">
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
      <input type="text" class="form-control" id="validationCustom05" value ="{{$editar[0]->cpf}}"  required>
      <div class="invalid-feedback">
        Por favor, informe um CPF válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">PIS/PASEP</label>
      <input type="text" class="form-control" id="validationCustom05" value = "" >
      <div class="invalid-feedback">
        Por favor, informe um PIS/PASEP válido.
    </div>
    </div>
 
    <div class="form-group row" style = " display:flex;
    justify-content:space-between; width: 100%; ">

    <div class="form-group col-md-2">
      <label for="validationCustom05">Identidade</label>
      <input type="text" class="form-control" id="validationCustom05" value ="{{$editar[0]->idt}}" required>
      <div class="invalid-feedback">
        Por favor, informe um RG válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Orgão Exp</label>
      <input type="text" class="form-control" id="validationCustom05" value ="{{$editar[0]->orgao_expedidor}}" required>
      <div class="invalid-feedback">
        Por favor, informe o Orgão Exp válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" id="validationCustomUsername" value ="{{$editar[0]->dt_emissao_idt}}" required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Cor Pele</label>
      <select id="12" class="form-control" >
      <option value="{{$editar[0]->id}}">{{$editar[0]->nmpele}}</option>
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
      <select id="12" class="form-select" >
      <option value="{{$editar[0]->id}}">{{$editar[0]->nmsangue}}</option>
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
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->titulo_eleitor}}"  required>
      <div class="invalid-feedback">
        Por favor, informe um Titulo eleitor Nr válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Zona</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->zona_tit}}" required>
      <div class="invalid-feedback">
        Por favor, informe um Titulo eleitor Nr válido.
    </div>
    </div>

    <div class="form-group col-md-1">
      <label for="validationCustom05">Seção</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->secao_tit}}" required>
      <div class="invalid-feedback">
        Por favor, informe uma Seção válida.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" id="validationCustomUsername" value = "{{$editar[0]->dt_titulo}}"required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">DDD</label>
      <select id="12" class="form-select" >
      <option value="{{$editar[0]->id}}">{{$editar[0]->dddesc}}</option>
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
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->celular}}"  required>
      <div class="invalid-feedback">
        Por favor, informe o Número de Celular.
    </div>
    </div>

    <div class="form-group row" style = " display:flex;
    justify-content:space-between; width: 100%; ">

  <div class="form-group col-md-2">
      <label for="validationCustom05">CTPS Nr</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->ctps}}" required>  
      <div class="invalid-feedback">
        Por favor, informe um CTPS Nr válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" id="validationCustomUsername" value = "{{$editar[0]->dt_emissao_ctps}}"required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Série</label>
      <input type="text" class="form-control" id="validationCustom05"  value = "{{$editar[0]->serie}}"required>
      <div class="invalid-feedback">
        Por favor, informe um Nr Série válido.
    </div>
    </div>
  
    <div class="form-group col-sm-2">
      <label for="validationCustomUsername">UF</label>
      <select id="12" class="form-select" >
      <option value="{{$editar[0]->id}}">{{$editar[0]->ufsgl}}</option>
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
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->reservista}}" required>
      
    </div>
    <div class="form-group row" style = "">

    <div class="form-group col-md-6">
      <label for="validationCustom05">Nome da Mãe</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->nome_mae}}" required>
      <div class="invalid-feedback">
        Por favor, informe o Nome da Mãe>
    </div>
    <br>
    </div>
  
    <div class="form-group col-md-6">
      <label for="validationCustom05">Nome do Pai</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->nome_pai}}" required>
    </div>
   
  </div>

  <div class="form-group row" style = "">
     
  <div class="form-group col-md-5">
      <label for="validationCustom05">Email</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar[0]->email}}" required>
    </div>

    <div class="form-group col-md-1">
      <label for="validationCustomUsername">Cat CNH</label>
      <select id="validationCustomUsername" class="form-control" >
        <option value="{{$editar[0]->id}}">{{$editar[0]->nmcnh}}</option>
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

<figure class="figure">
  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT29losWo_Df-O-bjW0A6tuH-NLoUorWQxrqS5HADgrkfySSPpRWjv8_Kb5itsXAlmB1ic&usqp=CAU/200x200" class="figure-img img-fluid rounded" alt="Imagem de um quadrado genérico com bordas arredondadas, em uma figure.">
  <a href = "#" >Alterar Foto</a>
</figure>
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
