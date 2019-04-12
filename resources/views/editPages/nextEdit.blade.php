@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'LoginController@restart', 'method' => 'POST']) !!}
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white;">Máte záujem o vytvorenie novej požiadavky?</b>
  </div>
  <div class="card-body">
    <h5 class="card-title">Vyberte jednu z nasledovných možností</h5>
    <button type="submit" class="btn btn-primary" name="action" value="goagain">Ďalšia požiadavka</button>
    <button type="submit" name="action" class="btn btn-primary" value="forgot">Odoslať požiadavky</button>
  </div>
</div> 
{!! Form::close() !!}
@endsection