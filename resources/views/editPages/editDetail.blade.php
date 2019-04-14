@extends('layouts.app')

@section('content')
{!! Form::open(['action' => 'EditController@saveInfo', 'method' => 'GET'])!!}
<input style="visibility:hidden;" name="id" value="{{$editKniha->id_knihy }}">
<div class="card" style="max-width: 50%; margin-left:auto; margin-right:auto;">
<div class="card-header" style="background-color:#3972a4;">
    <b style="color:white;">Požiadavka na zmenu knižného systému</b>
</div>
<div class="card-body">
    <div class="card-header" style="background-color:#3972a4;">
        <b style="color:white;">Autor</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <!--  -->
    <button type="button" id="undo" onclick="document.getElementById('authorEdit').value = '{{ $editKniha->autor }}'; document.getElementById('panacik').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="autor" id="authorEdit" value="{{ $editKniha->autor }}" style="margin-left: 1%; max-width:20%;" oninput="colorPanacik('panacik')" class="form-control" type="text">
    <i id="panacik" style="margin-left:5px;margin-top:10px;color:grey; font-size:20px;" class="fas fa-user-edit"></i>
        <input name="inputAutor" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">Názov</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <button type="button" id="undo2" onclick="document.getElementById('nazovEdit').value = '{{ $editKniha->nazov }}'; document.getElementById('panacik2').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="nazov" id="nazovEdit" value="{{ $editKniha->nazov }}" style="margin-left:1%; max-width:20%;" oninput="colorPanacik('panacik2')" class="form-control" type="text"><span>&nbsp;<i id="panacik2" style="margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
        <input name="inputNazov" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">Vydavateľstvo</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <button type="button" id="undo3" onclick="document.getElementById('vydavatelstvoEdit').value = '{{ $editKniha->vydavatelstvo }}';document.getElementById('panacik3').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="vydavatelstvo" id="vydavatelstvoEdit" value="{{ $editKniha->vydavatelstvo }}" style="margin-left:1%; max-width:20%;" oninput="colorPanacik('panacik3')" class="form-control" type="text"><span>&nbsp;<i id="panacik3" style="margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
        <input name="inputVydavatelstvo" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">Rok vydania</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <button type="button" id="undo4" onclick="document.getElementById('datumEdit').value = '{{ $editKniha->datum_vydania }}';document.getElementById('panacik4').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="date" id="datumEdit" value="{{ $editKniha->datum_vydania }}" style="margin-left:1%; max-width:20%;" oninput="colorPanacik('panacik4')" class="form-control" type="text"><span>&nbsp;<i id="panacik4" style="margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
        <input name="inputDatum" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">Počet strán</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <button type="button" id="undo5" onclick="document.getElementById('stranyEdit').value = '{{ $editKniha->pocet_stran }}';document.getElementById('panacik5').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="pages" id="stranyEdit" value="{{ $editKniha->pocet_stran }}" style="margin-left:1%; max-width:20%;" oninput="colorPanacik('panacik5')" class="form-control" type="text"><span>&nbsp;<i id="panacik5" style="margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
        <input name="inputPages" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">Jazyk</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <button type="button" id="undo6" onclick="document.getElementById('jazykEdit').value = '{{ $editKniha->jazyk }}';document.getElementById('panacik6').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="language" id="jazykEdit" value="{{ $editKniha->jazyk }}" style="margin-left:1%; max-width:20%;" oninput="colorPanacik('panacik6')" class="form-control" type="text"><span>&nbsp;<i id="panacik6" style="margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
        <input name="inputLanguage" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">ISBN</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <button type="button" id="undo7" onclick="document.getElementById('isbnEdit').value = '{{ $editKniha->ISBN }}';document.getElementById('panacik7').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="isbn" id="isbnEdit" value="{{ $editKniha->ISBN }}" style="margin-left:1%; max-width:20%;" oninput="colorPanacik('panacik7')" class="form-control" type="text"><span>&nbsp;<i id="panacik7" style="margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
        <input name="inputISBN" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">Rozmer</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <button type="button" id="undo8" onclick="document.getElementById('rozmerEdit').value = '{{ $editKniha->rozmer }}';document.getElementById('panacik8').style.color = 'grey'" style="color:grey;margin-left: 30px; font-size:20px;"class="fas fa-undo"></button>
    <input name="size" id="rozmerEdit" value="{{ $editKniha->rozmer }}" style="margin-left:1%; max-width:20%;" oninput="colorPanacik('panacik8')" class="form-control" type="text"><span>&nbsp;<i id="panacik8" style="margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
        <input name="inputSize" style="margin-left:10%; max-width:57%;" class="form-control" type="text" placeholder="Poznámka autora">        
    </div>
    <div class="card-header" style="margin-top:15px;background-color:#3972a4;">
        <b style="color:white;">Obsah</b>
    </div>
    <div class="row" style="margin-top: 10px;">
    <div class="col-md-1">
     <button type="button" id="undo10" onclick="asd('panacik10')" style="height: 30px;color:grey;margin-left: 15px; font-size:20px;"class="fas fa-undo"></button>
    <span>&nbsp;<i id="panacik10" style="margin-left:50%;margin-top:12px;color:grey;font-size:20px;" class="fas fa-user-edit"></i></span>
    </div>
    <div class="col-md-8">
  <textarea name="text" value="{{ $editKniha->obsah }}"class="form-control" id="obsahEdit" oninput="colorPanacik('panacik10')" style="margin-left:1%; height: 150px; width:820px;" >{{ $editKniha->obsah }}</textarea>
  <input name="inputText" style="margin-top: 10px; margin-left:1%;width:820px;" class="form-control" type="text" placeholder="Poznámka autora">        
  </div>
    </div>
    </div>
    <div class="card-footer" style="margin-top:15px;">
          <button type="submit" class="btn btn-outline-primary">Odoslať</button>
    </div>
</div>
</div>
{!! Form::close() !!}
@endsection