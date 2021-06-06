@extends('layouts.app')

@section('content')
<?php
if(!isset($_GET['finalpage']))
$_GET['finalpage'] = 1;
?>
<div class="card">
  <div class="card-header" style="background-color:#3972a4;">
    <b style="color:white; margin-left:45%">Zoznam editácií na spracovanie</b>
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
        <div class="row">
          <div class="col-sm-1">
          <a href="/confirm?finalpage={{ $_GET['finalpage']-1 }}" class="btn btn-outline-primary">Späť</a>
          </div>
            <div class="card-group">
              @if(count($editacie)>0)
                @foreach($editacie as $edit)
                <div class="card" style="margin-left: 5%;width: 350px;">
                  <div class="card-header" style="background-color:#3972a4;">
                      <b style="color:white;">Editácia</b>
                  </div>
                  <div class="card-body">
                      <b class="card-text">Autor: {{ $edit->autor }}</b> <br>
                      <b class="card-text">Názov: {{ $edit->nazov }} </b> <br>
                      <b class="card-text">Meno: {{ $edit->meno }}</b> <br>
                      <b class="card-text">Priezvisko: {{ $edit->priezvisko }}</b> <br>
                      <b class="card-text">Email: {{ $edit->email }}</b> <br>
                  </div>
                  <div class="card-footer">
                      <a class="btn btn-outline-primary" href="{{ route('confirmDetail',['id' => $edit->id_editacie]) }}"> Spracovať</a>  
                  </div>
              </div>
              @endforeach
                @else
                  <p>Nenašli sa editácie</p>
              @endif
            </div>
            <div class="col-sm-1" style="margin-left:35px;">
              <a href="/confirm?finalpage={{ $_GET['finalpage']+1 }}" class="btn btn-outline-primary">Ďalej</a>
              <input style="visibility:hidden;" name="finalpage" value="{{ $_GET['finalpage'] }}">       
            </div>
          </div>
    </div>
</div>
</div> 
@endsection