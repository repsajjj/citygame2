<?php

namespace CityGame\CityGame\Models;

class scenario
{
    private $ID;//number
    private $order;//none|ordered
    private $location;//string, city or location name
    private $description;//charlimit
    private $objectives; //array of objective objects

    public function __construct($array)
    {
        $this->create($array);
    }
    private function create($array)
    {
        $this->ID=$array['ID'];
        $this->description=$array['configuration']['description'];//charlimit
        $this->location=$array['configuration']['location'];//check if location is valid
        $this->order=$array['configuration']['order'];//check if type is valid
        $i=0;
        foreach ($array['objectives'] as $objective => $value) {
            $objective = new Objective($value);
            $i++;
            $this->objectives[$i]=$objective;
        }
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
    public function getOrder()
    {
        return $this->order;
    }
    public function getobjectives()
    {
        return $this->objectives;
    }
    public function print()
    {
        $out="<br />";
        $out=$out.$this->ID;
        $out=$out.": ";
        $out=$out.$this->description;
        $out=$out." at ";
        $out=$out.$this->location;
        $out=$out.", order:";
        $out=$out.$this->order;
        $out=$out."<br /> objectives: ";
        foreach ($this->objectives as $objective) {
            $out=$out.$objective->print();
        }
        return $out;
    }
}
