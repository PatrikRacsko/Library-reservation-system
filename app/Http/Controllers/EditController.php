<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use SoapClient;
use Session;
class EditController extends Controller
{
    public function index(Request $request)
    {
        $getUser = Session::has('user') ? Session::get('user') : null;
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Kniha?WSDL&readable");
        $vytlacok = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Vytlacok?WSDL&readable");
        $response_vytlacok = $vytlacok->getAll();
        $response = $client->getAll();
        for($i = 0; $i < count($response->knihas->kniha); $i++)
            $merged[$i] = $this->merge($response->knihas->kniha[$i], $response_vytlacok->vytlacoks->vytlacok[$i]);
        $collect = collect($merged);
        $request->session()->put('OBJ', $merged);
        $page = 1;
        $request->session()->put('flag', 2);
        $request->session()->put('user', $getUser);
        return view('editPages.bookCatalogue')->with('knihy', $collect->forPage($request->get('page'),3));
    }
    public function merge($model1, $model2)
    {
        $obj_merged = (object) array_merge((array) $model1, (array) $model2);
        return $obj_merged;
    }
    public function getDetails(Request $request, $id)
    {
        $getUser = Session::has('user') ? Session::get('user') : null;
        $getId = Session::has('OBJ') ? Session::get('OBJ') : null;
        for($i = 0; $i < count($getId); $i++)
        {
            if($getId[$i]->id_knihy == $id)
                $foundBook = $getId[$i];
        }
        $request->session()->put('user', $getUser);
        return view('editPages.editDetail')->with('editKniha', $foundBook);
    }
    public function saveInfo(Request $request)
    {
        $getUser = Session::has('user') ? Session::get('user') : null;
        $getAttr = $request->all();
        //print("<pre>".print_r($getAttr,true)."</pre>");
        $ArrToObj = (object)$getAttr;
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Citatel?WSDL&readable");
        $response = $client->getByAttributeValue(array("attribute_name" => "email", "attribute_value" => $getUser, "ids" => ""));
        $userID = $response->citatels->citatel->id_citatela;
        $toEditacia = $this->parseBook($ArrToObj, $userID);
        $toPoznamky = $this->parseComments($ArrToObj);
       // print("<pre>".print_r($toEditacia,true)."</pre>");
        //print("<pre>".print_r($toPoznamky,true)."</pre>");
        $editaciaClient = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Editacia?WSDL&readable");
        $editaciaResponse = $editaciaClient->insert(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => "", "Editacia" => $toEditacia));
        $poznamkyClient = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Poznamky?WSDL&readable");
        $poznamkyResponse = $poznamkyClient->insert(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => "", "Poznamky" => $toPoznamky));
        return redirect('/edit')->with('success', 'Požiadavka na editáciu bola úspešne odoslaná');
    }
    public function parseBook($ArrToObj, $userID)
    {
        $object = new \stdClass();
        $object->id = "";
        $object->name = "";
        $object->id_knihovnicka = 1;
        $object->id_citatel = (int)$userID;
        $object->id_vytlacok = (int)$ArrToObj->id;
        $object->edit_nazov = $ArrToObj->nazov;
        $object->edit_autor = $ArrToObj->autor;
        $object->edit_obsah = $ArrToObj->text;
        $object->edit_vydavatelstvo = $ArrToObj->vydavatelstvo;
        $object->edit_datum_vydania = $ArrToObj->date;
        $object->edit_jazyk = $ArrToObj->language;
        $object->edit_ISBN = $ArrToObj->isbn;
        $object->edit_pocet_stran = (int)$ArrToObj->pages;
        $object->edit_rozmer = $ArrToObj->size;
        $object->id_editacie = (int)$ArrToObj->id;
        return $object;
    }
    public function parseComments($ArrToObj)
    {
        $object = new \stdClass();
        $object->id = "";
        $object->name = "";
        $object->id_editacie = (int)$ArrToObj->id;
        $object->inputAutor = $ArrToObj->inputAutor;
        $object->inputNazov = $ArrToObj->inputNazov;
        $object->inputVydavatelstvo = $ArrToObj->inputVydavatelstvo;
        $object->inputDatum = $ArrToObj->inputDatum;
        $object->inputPages = $ArrToObj->inputPages;
        $object->inputLanguage = $ArrToObj->inputLanguage;
        $object->inputISBN = $ArrToObj->inputISBN;
        $object->inputSize = $ArrToObj->inputSize;
        $object->inputText = $ArrToObj->inputText;
        return $object;
    }
    public function findBook(Request $request)
    {
        $query = $request->get('search');
        $ucQuery = ucfirst($query);
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Kniha?WSDL&readable");
        $vytlacok = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Vytlacok?WSDL&readable");
        $response_vytlacok = $vytlacok->getAll();
        $response = $client->getAll();
        for($i = 0; $i < count($response->knihas->kniha); $i++)
            $merged[$i] = $this->merge($response->knihas->kniha[$i], $response_vytlacok->vytlacoks->vytlacok[$i]);
        //print_r((array)$merged);
        $array = array();
        for($i = 0; $i < count($merged); $i++)
        {
            $pos = strpos($merged[$i]->nazov, $ucQuery);
            if($pos !== false)
            {   
                array_push($array,$merged[$i]);
            }
        }
       // print_r($array);
         $collect = collect($array);
         $flag = 1;
         $request->session()->put('flag', 1);
         $request->session()->put('query', $ucQuery);
         return view('editPages.bookCatalogue')->with('knihy', $collect)->with('flag', $flag);
        }
}
