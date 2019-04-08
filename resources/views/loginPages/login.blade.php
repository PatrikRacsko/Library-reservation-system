@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'LoginController@index', 'method' => 'POST']) !!}
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white;">Prihlásenie - Identifikácia profilu</b>
  </div>
  <div class="card-body">
    <h5 class="card-title">Email<span style="color:red;">*</span></h5>
    {{Form::text('email', '', ['class' => 'form-control'])}}
    <h5 class="card-title">Heslo<span style="color:red;">*</span></h5>
    {{Form::password('pass', ['class' => 'form-control'])}}
    <br>
    {{Form::submit('Pokračovať', ['class' => 'btn btn-primary', 'placeholder' => 'Pokračovať'])}}
  </div>
</div> 
{!! Form::close() !!}
@endsection