@extends('layouts.app')

@section('content')
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
      <form action="/edit" method="GET">
        <div class="row">
          <div class="col-sm-1">
            <button class="btn btn-outline-primary" onclick="decrementValue()">Späť</button>
          </div>
              <div class="card-group">
                <div class="card">
                  <div class="card-header" style="background-color:#3972a4;">
                      <b style="color:white;">Editácia</b>
                  </div>
                  <div class="card-body">
                      <b class="card-text">Autor: Ján Botto</b> <br>
                      <b class="card-text">Názov: Traja Králi </b> <br>
                      <b class="card-text">Meno: Patrik</b> <br>
                      <b class="card-text">Priezvisko: Racsko</b> <br>
                      <b class="card-text">Email: Patrik.Racsko@gmail.com</b> <br>
                  </div>
                  <div class="card-footer">
                <!--      <button class="btn btn-outline-primary">Edituj</button> -->
                      <a class="btn btn-outline-primary"> Spracovať</a>
                  </div>
                </div>
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