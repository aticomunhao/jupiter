@extends('layouts.app')

@section('content')



<div class="input-group mb-3">
    <input type="number" class="form-control" name="banco">
        <select> 
                @foreach($lista as $listas)
                    <option value="{{$listas->id}}">{{$listas->banco}}-{{$listas->desc_ban}}</option>
                    @endforeach
        </select>
    <input type="text" class="form-control" name="Server">
</div>








@endsection