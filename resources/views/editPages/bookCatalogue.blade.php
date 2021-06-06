@extends('layouts.app')

@section('content')
<?php
if(!isset($_GET['page']))
  $_GET['page'] = 1;
/*if(isset($_GET['goBack']))
{
  $counter = $_GET['page'];
  if($counter >= 0)
  {
  $counter--;
  $_GET['page'] = $counter;
  }
}
if(isset($_GET['goForward']))
{
  $counter = $_GET['page'];
  $counter++;
  $_GET['page'] = $counter;
}*/
?>
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white; margin-left:45%">Zoznam kníh</b>
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-3">
        {!! Form::open(['action' => 'EditController@findBook', 'method' => 'GET']) !!}
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
              </div>
                {{Form::text('search', '', ['class' => 'form-control'])}}
                <!-- <input type="text" class="form-control"> -->
                <div class="input-group-append">
                {{Form::submit('Vyhľadaj', ['class' => 'btn btn-outline-secondary', 'placeholder' => 'Vyhľadaj'])}}
                  <!-- <button class="btn btn-outline-secondary" type="submit" name="query"> </button> -->
                </div>
          </div>
          {!! Form::close() !!}
          <?php 
            $getFlag = Session::has('flag') ? Session::get('flag') : null;
            $getQuery = Session::get('query');
            if($getFlag == 1)
            {
              echo "<a href='/edit'>Zmazať filter</a>";
              echo "<br>";
              echo "<b style='font-size:20px;'>Hľadali ste: ".$getQuery."</b>";
            }
          ?>
        </div>
        <div class="col-lg-9">
      <form id="myform" action="/edit" method="GET">
        <div class="row">
          <div class="col-sm-1">
              <a href="/edit?page={{ $_GET['page']-1 }}" class="btn btn-outline-primary">Späť</a>
          </div>
              <div class="card-group">
              @if(count($knihy) > 0)
                  @foreach($knihy as $kniha) 
                <div class="card">
                  <div class="card-header" style="background-color:#3972a4;">
                      <b style="color:white;">{{$kniha->nazov}}</b>
                  </div>
                  <div class="card-body">
                      <img class="img-thumbnail" src="{{ $kniha->img_url }}" style="margin-left:40px;max-height: 250px;">
                      <p style="visibility:hidden">{{$kniha->id_knihy}}</p>
                      <p class="card-text"><b>Autor:</b> {{$kniha->autor}}</p>
                      <p class="card-text"><b>Názov:</b> {{$kniha->nazov}} </p>
                      <p class="card-text"><b>Vydavateľstvo:</b> {{$kniha->vydavatelstvo}}</p>
                      <p class="card-text"><b>Rok vydania:</b> {{$kniha->datum_vydania}} </p>
                      <p class="card-text"><b>Počet strán:</b> {{$kniha->pocet_stran}}</p>
                      <p class="card-text"><b>Jazyk:</b> {{$kniha->jazyk}}</p>
                      <p class="card-text"><b>ISBN:</b> {{$kniha->ISBN}}</p>
                      <p class="card-text"><b>Rozmer:</b> {{$kniha->rozmer}}</p>
                      <p class="card-text" style="width: 250px;margin-left: auto; margin-right: auto;"><b>Obsah:</b><br> {{$kniha->obsah}}</p>
                  </div>
                  <div class="card-footer">
                <!--      <button class="btn btn-outline-primary">Edituj</button> -->
                      <!-- Sem mozem pridat id clanku a z objektu to natiahnut-->
                      <a class="btn btn-outline-primary" href="{{ route('editDetail',['id' => $kniha->id_knihy]) }}"> Edituj</a>  
                  </div>
                </div>
                @endforeach
                  @else
                      <p>Nenašli sa knihy</p>
              @endif
            </div>
            <div class="col-sm-1" style="margin-left:35px;">
              <a href="/edit?page={{ $_GET['page']+1 }}" class="btn btn-outline-primary">Ďalej</a>
              <input style="visibility:hidden;" name="page" value="{{ $_GET['page'] }}">
            </div>
          </div>
    </div>
    </form>
</div>
</div> 
@endsection