<?php
namespace CityGame\CityGame\Models;

/**
 *
 */
class Game
{
    public function __construct(\PDO $database = null)
    {
        $this->db=$database;
    }
}
