@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'ConfirmController@emailHim', 'method' => 'GET']) !!}
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white;">Vytvorenie emailu</b>
  </div>
  <div class="card-body">
    <h5 class="card-title">Email</h5>
    <input class="form-control" name="email" value="{{ $acceptedEditations->email }}">
    <h5 class="card-title">Obsah</h5>
    <input class="form-control" name="message" value="{{ $acceptedEditations->message }}">
    <br>
    {{Form::submit('Odoslať', ['class' => 'btn btn-primary', 'placeholder' => 'Pokračovať'])}}
  </div>
</div> 
{!! Form::close() !!}
@endsection