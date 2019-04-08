<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Collective\Html\HtmlServiceProvider;
use App\Soap;
use SoapClient;
class LoginController extends Controller
{
    private $obj;
    public function index(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'pass' => 'required'
        ]);
        $email = $request->get('email');
        $password = $request->get('pass');
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Citatel?WSDL&readable");
        $response = $client->getByAttributeValue(array("attribute_name" => "email", "attribute_value" => $email, "ids" => ""));
        if(empty($response->citatels->citatel))
            return view('loginPages.again');
        else
        {
            if($this->checkPassword($password, $response->citatels->citatel->heslo))
                return redirect('/edit')->with('success', 'Úspešné prihlásenie');
            else
                return view('loginPages.again');
        }
    }
    public function checkPassword($pass2, $pass)
    {
        if($pass2 == $pass)
            return true;
        else
            return false;
    }
    public function restart(Request $request)
    {
        switch ($request->input('action')) {
            case 'goagain':
                return view('loginPages.login');
                break;
    
            case 'forgot':
                return view('loginPages.newCredentials');
                break;
        }
    }
    public function getCredentials(Request $request)
    {
        //pridat boolean
        $email = $request->get('email');
        $client = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/Students/Team034Citatel?WSDL&readable");
        $nieco = $client->getByAttributeValue(array("attribute_name" => "email", "attribute_value" => $email, "ids" => ""));
        if(empty($nieco->citatels->citatel))
            return view('loginPages.newCredentials');
        else
        {
            $object = new \stdClass();
            $permitted_chars = 'abcdefghijklmnopqrstuvwxyz';
            $newpassword = substr(str_shuffle($permitted_chars), 0, 5);
            $object->id = $nieco->citatels->citatel->id;
            $object->name = $nieco->citatels->citatel->name;
            $object->priezvisko = $nieco->citatels->citatel->priezvisko;
            $object->email = $nieco->citatels->citatel->email;
            $object->datum_registracie = $nieco->citatels->citatel->datum_registracie;
            $object->heslo = $newpassword;
            $object->body = $nieco->citatels->citatel->body;
            $client2 = new SoapClient("http://labss2.fiit.stuba.sk/pis/ws/NotificationServices/Email?WSDL&readable");
            $notification = $client2->notify(array("team_id" => "034", "password" => "6rBoGU", "email" => $email, "subject" => "New password", "message" => $newpassword));
            $updateCredential = $client->update(array("team_id" => "034", "team_password" => "6rBoGU", "entity_id" => $object->id, "Citatel" => $object));
            return view('loginPages.login');
        }
    }
}
