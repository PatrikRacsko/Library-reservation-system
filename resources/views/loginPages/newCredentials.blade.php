@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'LoginController@getCredentials', 'method' => 'POST']) !!}
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white;">Vyžiadanie nového hesla</b>
  </div>
  <div class="card-body">
    <h5 class="card-title">Email<span style="color:red;">*</span></h5>
    {{Form::text('email', '', ['class' => 'form-control'])}}
    <br>
    {{Form::submit('Vyžiadaj nové heslo', ['class' => 'btn btn-primary'])}}
  </div>
</div> 
{!! Form::close() !!}
@endsection