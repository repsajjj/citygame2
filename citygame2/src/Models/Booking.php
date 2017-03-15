<?php

namespace CityGame\CityGame\Models;

class Booking
{
    private $firstname;
    private $lastname;
    private $email;
    private $phone;
    private $date;
    private $info;
    private $dateDB;
    private $rowsDB;
    private $manager;
    private $bulk;
    private $value;


    public function create(array $values)
    {
        $this->firstname = $values["firstname"];
        $this->lastname = $values["lastname"];
        $this->email = $values["email"];
        $this->phone = $values["phone"];
        $this->date = $values["date"];
        $this->info = $values["info"];

        return $this;
    }

    public function infoCheck()
    {
        if ($this->info == "Optional information") {
            $this->info = "/";
        }
    }


    public function save()
    {
        $database = new Database;
        $collection='citygame.booking';

        $values = ['firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'date' => $this->date,
                    'info' => $this->info];

        $database->insert($values, $collection);
    }

    public function validate()
    {
          //Checking if the firstname is valid (not too short or too long)
      if (strlen($this->firstname) < 2 || strlen($this->firstname) > 63) {
          throw new \Exception("Firstname "  . $this->firstname ." is not correct ");
      }
      //Checking if the lastname is valid (not too short or too long)
      if (strlen($this->lastname) < 2 || strlen($this->lastname) > 63) {
          throw new \Exception("Lastname "  . $this->lastname ." is not correct ");
      }
      //Checking if email is valid (not too short or too long)
      if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
          throw new \Exception("E-mail "  . $this->email ." is not correct ");
      }

      //Checking if the phone is valid (not too short or too long)
      if (strlen($this->phone) < 5 || strlen($this->phone) > 63) {
          throw new \Exception("Phone "  . $this->phone ." is not correct ");
      }

        return true;
    }

    public function freeDate()
    {
        $database = new Database;
        $collection='citygame.booking';

        $filter = ['date' =>$this->date];
        $options = ["projection" => ['date' => 1]];

        $this->rowsDB = $database->get($filter, $options, $collection);
        foreach ($this->rowsDB as $document) {
            $this->dateDB= $document->date;
        }

        if ($this->date == $this->dateDB) {
            throw new \Exception("There is already a booking on this day. <br> Please choose another day to book your game. ");
        }
        return true;
    }

    public function getBookedDate()
    {
      $database = new Database;
      $collection='citygame.booking';
      $filter = [];
      $options = ["projection" => ['date' => 1]];
      $this->rowsDB = $database->get($filter, $options, $collection);
      $result = " ";
      foreach ($this->rowsDB as $document) {
        $temp = new \DateTime($document->date);
        $temp2= $temp->getTimestamp();
        $result = $result . $temp2   . ",";
      }
      $result2 = preg_replace('/,$/', '', $result);
      return $result2;
    }

}
