@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white; margin-left:45%">Zoznam kníh</b>
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-3">
          <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
              </div>
                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="button-addon2">Vyhľadaj</button>  
                </div>
          </div>
        </div>
        <div class="col-lg-9">
      <form action="/edit" method="GET">
        <div class="row">
          <div class="col-sm-1">
            <button class="btn btn-outline-primary" onclick="decrementValue()">Späť</button>
          </div>
              <div class="card-group">
              @if(count($knihy) > 0)
                  @foreach($knihy as $kniha) 
                <div class="card">
                  <div class="card-header" style="background-color:#3972a4;">
                      <b style="color:white;">{{$kniha->nazov}}</b>
                  </div>
                  <div class="card-body">
                      <p class="card-text">Autor: {{$kniha->autor}}</p>
                      <p class="card-text">Názov: {{$kniha->nazov}} </p>
                      <p class="card-text">Vydavateľstvo: {{$kniha->vydavatelstvo}}</p>
                      <p class="card-text">Rok vydania: {{$kniha->datum_vydania}} </p>
                      <p class="card-text">Počet strán: {{$kniha->pocet_stran}}</p>
                      <p class="card-text">Jazyk: {{$kniha->jazyk}}</p>
                      <p class="card-text">ISBN: {{$kniha->ISBN}}</p>
                      <p class="card-text">Rozmer: {{$kniha->rozmer}}</p>
                      <p class="card-text" style="width: 250px;margin-left: auto; margin-right: auto;">Obsah: {{$kniha->obsah}}</p>
                  </div>
                  <div class="card-footer">
                      <button class="btn btn-outline-primary">Edituj</button>
                  </div>
                </div>
                @endforeach
                  @else
                      <p>Nenasli sa produkty</p>
              @endif
            </div>
            <div class="col-sm-1" style="margin-left:35px;">
              <button class="btn btn-outline-primary" onclick="incrementValue()" type="submit">Ďalej</button> 
              <input style="visibility:hidden;" id="number" name="page" value="1">             
            </div>
          </div>
    </div>
    </form>
</div>
</div> 
@endsection