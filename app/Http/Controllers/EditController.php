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
        return view('editPages.bookCatalogue')->with('knihy', $collect->forPage($request->get('page'),3));
    }
    public function merge($model1, $model2)
    {
        $obj_merged = (object) array_merge((array) $model1, (array) $model2);
        return $obj_merged;
    }
    public function getDetails(Request $request, $id)
    {
        $getId = Session::has('OBJ') ? Session::get('OBJ') : null;
        for($i = 0; $i < count($getId); $i++)
        {
            if($getId[$i]->id_knihy == $id)
                $foundBook = $getId[$i];
        }
        return view('editPages.editDetail')->with('editKniha', $foundBook);
    }
    public function saveInfo(Request $request)
    {
        $getAttr = $request->all();
        print_r($getAttr);
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
         return view('editPages.bookCatalogue')->with('knihy', $collect)->with('flag', $flag);
        }
}
