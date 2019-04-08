<?php

namespace App;

class Soap
{
    /**
     * int id (nillable = false, minoccurs = 1, maxoccurs = 1)
    * id
*string name (nillable = true, minoccurs = 1, maxoccurs = 1)
*string priezvisko (nillable = true, minoccurs = 1, maxoccurs = 1)
*string email (nillable = true, minoccurs = 1, maxoccurs = 1)
*string datum_registracie (nillable = true, minoccurs = 1, maxoccurs = 1)
*string heslo (nillable = true, minoccurs = 1, maxoccurs = 1)
*int body (nillable = false, minoccurs = 1, maxoccurs = 1)
     */
    private $id;
    private $name;
    private $email;
    private $surname;
    private $registration_date;
    private $password;
    private $points;
    function __construct($object) 
    {
        $this->name = $object->citatels->citatel->name;
        $this->id = $object->citatels->citatel->id;
        $this->email = $object->citatels->citatel->email;
        $this->surname = $object->citatels->citatel->priezvisko;
        $this->registration_date = $object->citatels->citatel->datum_registracie;
        $this->password = $object->citatels->citatel->heslo;
        $this->points = $object->citatels->citatel->body;
    }
    public function setID($id)
    {
        $this->id = $id;;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setRegistration($reg)
    {
        $this->registration_date = $reg;
    }
    public function setPoints($points)
    {
        $this->points = $points;
    }
    public function getID()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getSurname()
    {
        return $this->surname;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRegistration()
    {
        return $this->registration_date;
    }
    public function getPoints()
    {
        return $this->points;
    }

}