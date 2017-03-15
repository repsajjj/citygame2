<?php
namespace CityGame\CityGame\Models;

/**
 *
 */
class Key
{
    private $type = "";
    public $key="";


    public function __construct(\SlimSession\Helper $session, \PDO $database = null)
    {
        $this->setkey($session->get('key'));
    }

    public function getType()
    {
        //make array $master with all the master keys
      //make array participians with all the teams there keys
      if ($this->key == "789") {//master   //key is in $master
        //session keytype master
        return "master";
      } elseif ($this->key=="456" || $this->key=="123") {//team1 or team2

        //session keytype team1
        return "player";
        //show file upload and stats? idk
      } else {
          //echo "invallid key used";
      return "logout";
      }//*/
    }
    public function setkey($key)
    {
        $this->key=$key;
    }
    public function getkey()
    {
        return $this->key;
    }

    public function isValid()
    {
        $out=false;
        if (isset($this->key)) {
            if ($this->getType()=="master" || $this->getType()=="player") {
                $out=true;
            }
        }
        return $out;
    }
}
