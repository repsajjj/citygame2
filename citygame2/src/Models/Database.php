<?php

namespace CityGame\CityGame\Models;

class Database
{
    private $manager;
    private $bulk;

    public function __construct()
    {
        $this->manager = new \MongoDB\Driver\Manager('mongodb://Admin:Master@ds149049.mlab.com:49049/citygame');
        $this->bulk = new \MongoDB\Driver\BulkWrite;

        return $this;
    }

    public function insert($values, $collection)
    {
        $queryInsert=$values;

        $this->bulk->insert($queryInsert);
        $this->manager->executeBulkWrite($collection, $this->bulk);
    }

    public function get($filter, $options, $collection)
    {
        $query = new \MongoDB\Driver\Query($filter, $options);
        $rows = $this->manager->executeQuery($collection, $query);

        return $rows;
    }
}
