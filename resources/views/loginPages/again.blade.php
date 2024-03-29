@extends('layouts.app')

@section('content')
<div class="alert alert-danger" style="width: 25%; margin-left: 35%;">
    <label style="margin-left: 35%;">Nesprávne prihlasovacie údaje</label>
</div>
{!! Form::open(['action' => 'LoginController@restart', 'method' => 'POST']) !!}
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white;">Chcete prihlásenie zopakovať?</b>
  </div>
  <div class="card-body">
    <h5 class="card-title">Vyberte jednu z nasledovných možností</h5>
    <button type="submit" class="btn btn-primary" name="action" value="goagain">Zopakovať prihlásenie</button>
    <button type="submit" name="action" class="btn btn-primary" value="forgot">Zabudol som heslo</button>
  </div>
</div> 
{!! Form::close() !!}
@endsection