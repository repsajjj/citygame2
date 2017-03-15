<?php

namespace CityGame\CityGame\Models;

class Objective
{
    private $type;
    private $location;
    private $description;
    private $ID;
    private $teams;

    public function __construct($object)
    {
        $this->create($object);
    }
    private function create($object)
    {
        $this->ID=$object['ID'];//objectives needs to be done in order of ID
        $this->description=$object['description'];//charlimit
        $this->location=$object['location'];//check if location is valid
        $this->type=$object['type'];//check if type is valid
        $this->others=$object['others'];//check if compatible with type
    }
    public function getID()
    {
        return $this->ID;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getOthers()
    {
        return $this->others;
    }
    public function print()
    {
        $out="<br />";
        $out=$out.$this->ID;
        $out=$out.":";
        $out=$out.$this->description;
        $out=$out.", loc:";
        $out=$out.$this->location[0].", ".$this->location[1];
        $out=$out.", type=\"";
        $out=$out.$this->type;
        $out=$out."\" with: ";
        $out=$out.$this->others;
        return $out;
    }
}
