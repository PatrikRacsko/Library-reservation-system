@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'ConfirmController@saveInfo', 'method' => 'GET'])!!}
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white; margin-left:45%">Zoznam editácií na spracovanie</b>
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-3">
          <div class="card">
              <div class="card-header" style="background-color:#3972a4;">
                  <b style="color:white;">Profil používateľa</b>
              </div>
                <div class="card-body">
                      <b class="card-text">Meno: </b> {{ $lastEdit->meno }}<br>
                      <b class="card-text">Priezvisko: </b> {{ $lastEdit->priezvisko }}<br>
                      <b class="card-text">Dátum registrácie: </b>{{ $lastEdit->datum_registracie }} <br>
                      <b class="card-text">Email: </b> {{ $lastEdit->email }}<br>                      
                      <b class="card-text">Počet bodov: </b> {{ $lastEdit->body }}<br>
                </div>
          </div>
        </div>
        <div class="col-lg-9">
      <form action="/edit" method="GET">
        <div class="row">
              <div class="card-group">
              @if(count($changedEditation) > 0)
                @foreach($changedEditation as $change => $value)
                <div class="card">
                  <div class="card-header" style="background-color:#3972a4;">
                      <b style="color:white;">{{ $change }}</b>
                  </div>
                  <div class="card-body d-flex flex-column">
                      <b class="card-text">Original: </b> {{ $value[0]}}<br>
                      <b class="card-text">Návrh: </b> {{ $value[1] }}<br>
                       <?php if(!empty($value[2]))
                            {
                              echo "<b class='card-text'>Pripomienka: </b> $value[2]<br>";
                            }
                            else{
                              echo "<b class='card-text'>Pripomienka: </b>Nebola pridaná pripomienka<br>";
                            }
                       ?>
                      <!-- <b class="mt-auto card-text">Úprava: </b><br>
                      <input value="{{ $value[1] }}" class="form-control"> -->
                  </div>
                  <div class="card-footer">
                      <input value="{{ $value[1] }}" name="check_{{ $change }}"class="btn btn-outline-primary" type="checkbox"><b>Potvrdiť</b>
                  </div>
                </div>
              @endforeach
              @else
                <p>Nenašli sa editácie</p>
              @endif
            </div>
          </div>
    </div>
    </form>
</div>
<div class="card-footer">
  <button type="submit" style="margin-left:50%;"class="btn btn-outline-primary">Potvrdiť požiadavky</button>
  <input name="email" value="{{ $lastEdit->email}}" style="visibility:hidden;">
</div>
</div>
{!! Form::close() !!}
@endsection