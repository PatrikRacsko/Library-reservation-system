<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use Session;

class ConfirmController extends Controller
{
    public function index(Request $request)
    {
        //ked je jeden zaznam tak dostanem object inak array
        $editaciaClient = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Editacia?WSDL&readable");
        $editaciaResponse = $editaciaClient->getAll();
        $knihyClient = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Kniha?WSDL&readable");
        $knihyResponse = $knihyClient->getAll();
        $vytlackyClient = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Vytlacok?WSDL&readable");
        $vytlackyResponse = $vytlackyClient->getAll();
        for($i = 0; $i < count($knihyResponse->knihas->kniha); $i++)
            $knihy_merged[$i] = $this->merge($knihyResponse->knihas->kniha[$i], $vytlackyResponse->vytlacoks->vytlacok[$i]);
    //    if(gettype($editaciaResponse->editacias->editacia) == "array")
            $toObj = (object) $editaciaResponse->editacias->editacia;      
      //  else
        //    $toObj = $editaciaResponse->editacias;
        //print("<pre>".print_r($toObj->id_citatel,true)."</pre>");
        $users = array();
        $notes = array();
        //echo gettype($toObj);
            foreach($toObj as $obj)
            {
             //   print("<pre>".print_r($obj,true)."</pre>");
                array_push($users,$this->fetchUser($obj->id_citatel));
                array_push($notes,$this->fetchNotes($obj->id_editacie));
            }
        $edits = $editaciaResponse->editacias->editacia;
        //print("<pre>".print_r($edits,true)."</pre>");
        $users2 = array();
        $poznamkys2 = array();
        foreach($users as $user)
            array_push($users2, $user->citatels->citatel);
        foreach($notes as $note)
            array_push($poznamkys2, $note->poznamkys->poznamky);
        for($i = 0; $i<count($edits); $i++)
            $merged[$i]=$this->merge($edits[$i], $users2[$i]);
        for($i = 0; $i < count($merged); $i++)
            $merged2[$i] = $this->merge($merged[$i], $poznamkys2[$i]);
        $final = $this->addTogether($merged2, $knihy_merged);
        $collect = collect($final);
        $request->session()->put('getAll', $final);
        return view('confirmPages.confirm')->with('editacie', $collect->forPage($request->get('finalpage'),3));
    }
    public function confirm(Request $request, $id)
    {
        $getDetails = Session::has('getAll') ? Session::get('getAll') : null;
        for($i = 0; $i < count($getDetails); $i++)
        {
            if($getDetails[$i]->id_editacie == $id)
                $foundBook = $getDetails[$i];
        }
        //print("<pre>".print_r($foundBook,true)."</pre>");
        $copied = $foundBook;
       $getChanged = $this->compareInside($foundBook, $copied);
        //print("<pre>".print_r($getChanged,true)."</pre>");
        $request->session()->put('aktualizujDatabazu', $foundBook);
        return view('confirmPages.confirmDetails')->with('lastEdit', $foundBook)->with('changedEditation', $getChanged);
    }
    public function compareInside($original, $copy)
    {
        $result = array();
        if(strcmp($original->nazov, $copy->edit_nazov) != 0)
        {
            if($original->inputNazov == '')
            {
                $result += ['Názov' => $original->nazov, $copy->edit_nazov];
                
            }
            else
            {
                $result += ['Názov' => [$original->nazov, $copy->edit_nazov, $original->inputNazov]];
            }
        }
        if(strcmp($original->autor, $copy->edit_autor) != 0)
        {
            if($original->inputAutor == '')
            {
                $result += ['Autor' => [$original->autor, $copy->edit_autor]];
            }
            else
            {
                //array_push($result,['autor' => [$original->autor,$copy->edit_autor,$original->inputAutor]]);
                $result += ["Autor"=>[$original->autor,$copy->edit_autor,$original->inputAutor]];
            }
        }
        if(trim($original->obsah) != trim($copy->edit_obsah))
        {
            if($original->inputText == '')
            {
                $result += ['Obsah' => [$original->obsah, $copy->edit_obsah]];
            }
            else
            {
                $result += ['Obsah' => [$original->obsah, $copy->edit_obsah, $original->inputText]];
            }
        }
        if(strcmp($original->vydavatelstvo, $copy->edit_vydavatelstvo) != 0)
        {
            if($original->inputVydavatelstvo == '')
            {
                $result += ['Vydávateľstvo' => [$original->vydavatelstvo, $copy->edit_vydavatelstvo]];
            }
            else
            {
                $result += ['Vydávateľstvo' => [$original->vydavatelstvo, $copy->edit_vydavatelstvo, $original->inputVydavatelstvo]];
            }
        }
        if(strcmp($original->datum_vydania, $copy->edit_datum_vydania) != 0)
        {
            if($original->inputDatum == '')
            {
                $result += [ 'Dátum vydania' => [$original->datum_vydania, $copy->edit_datum_vydania]];
            }
            else
            {
                $result += [ 'Dátum vydania' => [$original->datum_vydania, $copy->edit_datum_vydania, $original->inputDatum]];
            }
        }
        if(strcmp($original->jazyk, $copy->edit_jazyk) != 0)
        {
            if($original->inputLanguage == '')
            {
                $result += ['Jazyk' => [$original->jazyk, $copy->edit_jazyk]];
            }
            else
            {
                $result += [ 'Jazyk' => [$original->jazyk, $copy->edit_jazyk, $original->inputLanguage]];
            }
        }
        if(strcmp($original->ISBN, $copy->edit_ISBN) != 0)
        {
            if($original->inputISBN == '')
            {
                $result += ['ISBN' => [$original->ISBN, $copy->edit_ISBN]];
            }
            else
            {
                $result += ['ISBN' => [$original->ISBN, $copy->edit_ISBN, $original->inputISBN]];
            }
        }
        if(strcmp($original->pocet_stran, $copy->edit_pocet_stran) != 0)
        {
            if($original->inputPages == '')
            {
                $result += ['Počet strán' => [$original->pocet_stran, $copy->edit_pocet_stran]];
            }
            else
            {
                $result += ['Počet strán' => [$original->pocet_stran, $copy->edit_pocet_stran, $original->inputPages]];
            }
        }
        if(strcmp($original->rozmer, $copy->edit_rozmer) != 0)
        {
            if($original->inputSize == '')
            {
                $result += ['Rozmer' => [$original->rozmer, $copy->edit_rozmer]];
            }
            else
            {
                $result += ['Rozmer' => [$original->rozmer, $copy->edit_rozmer, $original->inputSize]];
            }
        }
        return $result;
    }
    public function addTogether($editacia, $knihy)
    {
        $merged = array();
        foreach($editacia as $edit)
        {
            foreach($knihy as $kniha)
            {
                if($edit->id_vytlacok == $kniha->id_knihy)
                    array_push($merged,(object) array_merge((array)$edit, (array)$kniha));
            }
        }
        return $merged;
    }
    public function merge($model1, $model2)
    {
        $obj_merged = (object) array_merge((array) $model1, (array) $model2);
        return $obj_merged;
    }
    public function fetchUser($userID)
    {
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Citatel?WSDL&readable");
        $response = $client->getByAttributeValue(array("attribute_name" => "id_citatela", "attribute_value" => $userID, "ids" => ""));
        return $response;
    }
    public function fetchNotes($editID)
    {
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Poznamky?WSDL&readable");
        $response = $client->getByAttributeValue(array("attribute_name" => "id_editacie", "attribute_value" => $editID, "ids" => ""));
        return $response;
    }
    public function saveInfo(Request $request)
    {
        $checked = $request->all();
        $object = (object) $checked;
        if(count($checked) > 1)
        {
        //print("<pre>".print_r($checked,true)."</pre>");
        $arr_result = array();
        foreach($checked as $key => $value)
        {
            $exp_key = explode('_', $key);
            if($exp_key[0] == 'check')
            {
                 $arr_result += [strtolower($exp_key[1]) => $value];
            }
        }
        $points = count($arr_result)*2;
        $this->updatePoints($object->email, $points);
        $this->updateBooks($arr_result);
        $this->deleteEditacia();

        $accepted = new \StdClass;
        $accepted->message = "Vaše požiadavky na úpravu boli akceptované";
        $accepted->email = $object->email;
        return view('confirmPages.confirmFeedback')->with('acceptedEditations', $accepted);
        }
        else
        {
            $this->deleteEditacia();
            $rejected = new \StdClass;
            $rejected->message = "Vaše požiadavky na úpravu neboli akceptované";
            $rejected->email = $object->email;
            return view('confirmPages.confirmFeedback')->with('acceptedEditations', $rejected);
        }
    }
    public function deleteEditacia()
    {
        $original = Session::has('aktualizujDatabazu') ? Session::get('aktualizujDatabazu') : null;
        //print("<pre>".print_r($original,true)."</pre>");
        $clientEdit = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Editacia?WSDL&readable");
        $responseEdit = $clientEdit->getByAttributeValue(array("attribute_name" => "id_editacie", "attribute_value" => $original->id_editacie, "ids" => ""));
        $response = $clientEdit->delete(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => $responseEdit->editacias->editacia->id));
        $clientNotes = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Poznamky?WSDL&readable");        
        $responseNotes = $clientNotes->getByAttributeValue(array("attribute_name" => "id_editacie", "attribute_value" => $original->id_editacie, "ids" => ""));
        $response2 = $clientNotes->delete(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => $responseNotes->poznamkys->poznamky->id));
    }
    public function updateBooks($array)
    {
        $original = Session::has('aktualizujDatabazu') ? Session::get('aktualizujDatabazu') : null;
        $objectOriginal = (object) $original;
       // print("<pre>".print_r($objectOriginal, true)."</pre>");
        $result = new \StdClass;
        $result->id = $this->getKnihaEntityID($objectOriginal->nazov);        ;
        $result->name = "";
        $result->id_knihy = $objectOriginal->id_kniha;
        $result->img_url = $objectOriginal->img_url;
        $notes = new \StdClass;
        $notes->id = $this->getVytlacokEntityID($objectOriginal->id_kniha);
        $notes->name = "";
        $notes->id_kniha = $objectOriginal->id_kniha;
        $objectArray = (object) $array;
        if(array_key_exists('názov', $array))
        {
            $result->nazov = $array['názov'];
        }
        else
        {
            $result->nazov = $objectOriginal->nazov;
        }
        if(array_key_exists('autor', $array))
        {
            $result->autor = $array['autor'];
        }
        else
        {
            $result->autor = $objectOriginal->autor;
        }
        if(array_key_exists('vydávateľstvo', $array))
        {
            $result->vydavatelstvo = $array['vydávateľstvo'];
        }
        else
        {
            $result->vydavatelstvo = $objectOriginal->vydavatelstvo;
        }
        if(array_key_exists('dátum vydania', $array))
        {
            $notes->datum_vydania = $array['dátum vydania'];
        }
        else
        {
            $notes->datum_vydania = $objectOriginal->datum_vydania;
        }
        if(array_key_exists('jazyk', $array))
        {
            $notes->jazyk = $array['jazyk'];
        }
        else
        {
            $notes->jazyk = $objectOriginal->jazyk;
        }
        if(array_key_exists('obsah', $array))
        {
            $result->obsah = $array['obsah'];
        }
        else
        {
            $result->obsah = $objectOriginal->obsah;
        }
        if(array_key_exists('rozmer', $array))
        {
            $notes->rozmer = $array['rozmer'];
        }
        else
        {
            $notes->rozmer = $objectOriginal->rozmer;
        }
        if(array_key_exists('isbn', $array))
        {
            $notes->ISBN = $array['isbn'];
        }
        else
        {
            $notes->ISBN = $objectOriginal->ISBN;
        }
        if(array_key_exists('počet strán', $array))
        {
            $notes->pocet_stran = $array['počet strán'];
        }
        else
        {
            $notes->pocet_stran = $objectOriginal->pocet_stran;
        }
        //print("<pre>".print_r($result,true)."</pre>");
      //print("<pre>".print_r($notes,true)."</pre>");
       
        $knihaClient = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Kniha?WSDL&readable");        
        $knihaResponse = $knihaClient->update(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => $result->id, "Kniha" => $result));
        $vytlacokClient = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Vytlacok?WSDL&readable");
        $vytlacokResponse = $vytlacokClient->update(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => $notes->id, "Vytlacok" => $notes));
    }
    public function getKnihaEntityID($nazov)
    {
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Kniha?WSDL&readable");
        $response = $client->getByAttributeValue(array("attribute_name" => "nazov", "attribute_value" => $nazov, "ids" => ""));
     //   print("<pre>".print_r($response,true)."</pre>");
        return $response->knihas->kniha->id;
    }
    public function getVytlacokEntityID($id)
    {
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Vytlacok?WSDL&readable");
        $response = $client->getByAttributeValue(array("attribute_name" => "id_kniha", "attribute_value" => $id, "ids" => ""));
       // print("<pre>".print_r($response,true)."</pre>");
        return $response->vytlacoks->vytlacok->id;
    }
    public function updatePoints($email, $points)
    {  
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Citatel?WSDL&readable");
        $userResponse = $client->getByAttributeValue(array("attribute_name" => "email", "attribute_value" => $email, "ids" => ""));
        $pointsAtStart = $userResponse->citatels->citatel->body;
        $sumPoints = $pointsAtStart + $points;
        $updateUser = new \StdClass;
        $updateUser->id = $userResponse->citatels->citatel->id;
        $updateUser->name = "";
        $updateUser->priezvisko = $userResponse->citatels->citatel->priezvisko;
        $updateUser->email = $userResponse->citatels->citatel->email;
        $updateUser->datum_registracie = $userResponse->citatels->citatel->datum_registracie;
        $updateUser->heslo = $userResponse->citatels->citatel->heslo;
        $updateUser->body = $sumPoints;
        $updateUser->id_citatela = $userResponse->citatels->citatel->id_citatela;
        $updateUser->meno = $userResponse->citatels->citatel->meno;
        $updateCredential = $client->update(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => $updateUser->id, "Citatel" => $updateUser));
    }
    public function emailHim(Request $request)
    {
        $message = $request->all();
        $objectMessage = (object)$message;
        $client2 = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/NotificationServices/Email?WSDL&readable");
        $notification = $client2->notify(array("team_id" => "034", "password" => "6rBoGU", "email" => $objectMessage->email, "subject" => "Odpoveď na Vašu požiadavku", "message" => $objectMessage->message));
        return redirect('/confirm')->with('success', 'Používateľ bol úspešne informovaný emailom');
    }
}
