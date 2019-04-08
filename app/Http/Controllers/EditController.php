<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use SoapClient;

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
        //$paginated = $collect->forPage($request->get('page'),3);
        return view('editPages.bookCatalogue')->with('knihy', $collect->forPage($request->get('page'),3));
    }
    public function merge($model1, $model2)
    {
        $obj_merged = (object) array_merge((array) $model1, (array) $model2);
        return $obj_merged;
    }
}
