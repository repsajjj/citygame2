<?php

namespace CityGame\CityGame\Models;

class Scores
{
    private $timestamp;
    private $score;
    private $team;
    private $filter;
    private $options;
    private $rowsDB;
    private $manager;
    private $bulk;
    private $rows;

    public function create(array $values)
    {
        $this->timestamp = $values["timestamp"];
        $this->score = $values["score"];
        $this->team=$values["team"];
        return $this;
    }

    public function save()
    {
        $database = new Database;
        $collection='citygame.score';

        $values = ['timestamp' => $this->timestamp,
                    'score' => $this->score,
                    'team' => $this->team];
        $database->insert($values, $collection);
    }

    public function getScore()
    {
        $database = new Database;
        $collection='citygame.score';

        $options = ["sort" => ['score' => -1]];
    //Leeg laten anders werkt het niet
    $filter=[];

        $this->rowsDB = $database->get($filter, $options, $collection);
        foreach ($this->rowsDB as $document) {
            echo "Team: $document->teamname <br/>";
            echo "Date: " , gmdate("d-m-Y", $document->timestamp), "<br/>"   ;
            echo "Score: $document->score <br/>";
            echo "<br/>";
        }
    }
}
