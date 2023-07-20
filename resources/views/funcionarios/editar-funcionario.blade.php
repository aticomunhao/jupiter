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
    <form method = 'POST' action = "/atualizar-funcionario/{{$editar->id_pes}}">
     
      @csrf
   
  <div class="form-group row" style = "display:flex;
    justify-content:space-between; width: 100%;">
    <div class="form-group col-md-2">
      <label for="validationCustom01">Matricula</label>
      <input type="text" name = "matr" class="form-control" value ="{{$editar->matricula}}"  required>
      <div class="invalid-feedback">
        Por favor, informe o Número da Matrícula.
      </div>
    </div>
    <div class="form-group col-md-6">
      <label for="validationCustom02">Nome Completo</label>
      <input type="text" name = "nome" class="form-control" value ="{{$editar->nome_completo}}"  required>
    </div>
    <br>
    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Nascimento</label>
      <input type="date" class="form-control" value ="{{$editar->dt_nascimento}}" required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Nascimento.
    </div>
    </div>
    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Sexo</label>
      <select id="12" class="form-control" >
      <option value=""></option>
        @foreach ($tbsexo as $tipo)
        <option value= "{{$tipo}}" @if($editar->tipo == $tipo) selected @endif>{{$tipo}}</option>

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
      <select id="12" class="form-control" >
      <option value=""></option>
        @foreach ($tbnacionalidade as $local)
        <option value= "{{$local}}" @if($editar->local == $local) selected @endif>{{$local}}</option>

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
      <select id="12" class="form-select" >
      <option value=""></option>
        @foreach ($tpcidade as $descricao)
        <option value= "{{$descricao}}" @if($editar->descricao == $descricao) selected @endif>{{$descricao}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um UF válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">CPF</label>
      <input type="text" class="form-control" id="validationCustom05" value ="{{$editar->cpf}}"  required>
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
      <input type="text" class="form-control" id="validationCustom05" value ="{{$editar->idt}}" required>
      <div class="invalid-feedback">
        Por favor, informe um RG válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Orgão Exp</label>
      <input type="text" class="form-control" id="validationCustom05" value ="{{$editar->orgao_expedidor}}" required>
      <div class="invalid-feedback">
        Por favor, informe o Orgão Exp válido.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" id="validationCustomUsername" value ="{{$editar->dt_emissao_idt}}"required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Cor Pele</label>
      <select id="12" class="form-control" >
      <option value=""></option>
        @foreach ($tbpele as $nome_cor)
        <option value= "{{$nome_cor}}" @if($editar->nome_cor == $nome_cor) selected @endif>{{$nome_cor}}</option>

        @endforeach 
</select>
      <div class="invalid-feedback">
        Por favor, selecione a Cor da Pele.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Tipo Sanguineo</label>
      <select id="12" class="form-select" >
      <option value=""></option>
        @foreach ($tbsangue as $nome_sangue)
        <option value= "{{$nome_sangue}}" @if($editar->nome_sangue == $nome_sangue) selected @endif>{{$nome_sangue}}</option>

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
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->titulo_eleitor}}"  required>
      <div class="invalid-feedback">
        Por favor, informe um Titulo eleitor Nr válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Zona</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->zona_tit}}" required>
      <div class="invalid-feedback">
        Por favor, informe um Titulo eleitor Nr válido.
    </div>
    </div>

    <div class="form-group col-md-1">
      <label for="validationCustom05">Seção</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->secao_tit}}" required>
      <div class="invalid-feedback">
        Por favor, informe uma Seção válida.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" id="validationCustomUsername" value = "{{$editar->dt_titulo}}"required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">DDD</label>
      <select id="12" class="form-select" >
      <option value=""></option>
        @foreach ($tbddd as $descricao)
        <option value= "{{$descricao}}" @if($editar->descricao == $descricao) selected @endif>{{$descricao}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um DDD válido.
    </div>
    </div> 
    
    <div class="form-group col-md-2">
      <label for="validationCustom05">Celular</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->celular}}"  required>
      <div class="invalid-feedback">
        Por favor, informe o Número de Celular.
    </div>
    </div>

    <div class="form-group row" style = " display:flex;
    justify-content:space-between; width: 100%; ">

  <div class="form-group col-md-2">
      <label for="validationCustom05">CTPS Nr</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->ctps}}" required>  
      <div class="invalid-feedback">
        Por favor, informe um CTPS Nr válido.
    </div>
    <br>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustomUsername">Data de Emissão</label>
      <input type="date" class="form-control" id="validationCustomUsername" value = "{{$editar->dt_emissao_ctps}}"required>
      <div class="invalid-feedback">
        Por favor, selecione a Data de Emissão.
    </div>
    </div>

    <div class="form-group col-md-2">
      <label for="validationCustom05">Série</label>
      <input type="text" class="form-control" id="validationCustom05"  value = "{{$editar->serie}}"required>
      <div class="invalid-feedback">
        Por favor, informe um Nr Série válido.
    </div>
    </div>
  
    <div class="form-group col-md-1">
      <label for="validationCustomUsername">UF</label>
      <select id="12" class="form-select" >
      <option value=""></option>
        @foreach ($tpufidt as $sigla)
        <option value= "{{$sigla}}" @if($editar->sigla == $sigla) selected @endif>{{$sigla}}</option>

        @endforeach
      </select>
      <div class="invalid-feedback">
        Por favor, selecione um UF válido.
    </div>
    </div> 

    <div class="form-group col-md-2">
      <label for="validationCustom05">Reservista</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->reservista}}" >
      
    </div>
    <div class="form-group row" style = "">

    <div class="form-group col-md-6">
      <label for="validationCustom05">Nome da Mãe</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->nome_mae}}" required>
      <div class="invalid-feedback">
        Por favor, informe o Nome da Mãe>
    </div>
    <br>
    </div>
  
    <div class="form-group col-md-6">
      <label for="validationCustom05">Nome do Pai</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->nome_pai}}" required>
    </div>
   
  </div>

  <div class="form-group row" style = "">
     
  <div class="form-group col-md-5">
      <label for="validationCustom05">Email</label>
      <input type="text" class="form-control" id="validationCustom05" value = "{{$editar->email}}" required>
    </div>

    <div class="form-group col-md-1">
      <label for="validationCustomUsername">Cat CNH</label>
      <select id="12" class="form-select" >
      <option value=""></option>
        @foreach ($tpcnh as $nome_cat)
        <option value= "{{$nome_cat}}" @if($editar->nome_cat == $nome_cat) selected @endif>{{$nome_cat}}</option>

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
