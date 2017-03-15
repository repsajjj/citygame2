<?php
$manager = new MongoDB\Driver\Manager('mongodb://Jasper:Jasper@ds149049.mlab.com:49049/citygame');

$bulk = new MongoDB\Driver\BulkWrite;                                           //Insert waardes
$queryInstert = ['_id' => new MongoDB\BSON\ObjectID, 'name' => 'BrolCar', 'price' => 8888888];
$bulk->insert($queryInstert);
//$manager->executeBulkWrite('citygame.Cars', $bulk);


$filter = [];
$options = ["sort" => ["price" => -1]];                                         //Sorteren

$filter2 = ['name' => "Audi"];                                                  // 1 waarde uitfilteren
$options2 = [];


//$query = new MongoDB\Driver\Query([]);                                        //Alle data uit de DB krijgen
$query = new MongoDB\Driver\Query($filter, $options);                           //Specifieke data uit de DB krijgen

$rows = $manager->executeQuery("citygame.Cars", $query);


foreach ($rows as $document) {
    echo "Name: $document->name <br/>";
    echo "Price: $document->price €  <br/>";
    echo "<br/>";
}



//!!! OUDE VERSIE !!! (PHP 5.6)
//$m = new MongoClient('mongodb://ds149049.mlab.com:49049/citygame', [
//    'username' => 'Jasper',
//    'password' => 'Jasper',
//    'db'       => 'citygame'
//]);

//$db = $m->citygame;
//$collection = $db->Cars;


//$query2 = array( 'name' => 'Koenigseg', 'price' => '100000000' );             //Data in DB
//$collection->insert($query2);


//$query1 = array('name' => 'Audi');                                            //Query voor filteren volgens 1 term
//$cursor_q1 = $collection->find($query1);

//$cursor_all = $collection->find();                                              // Alle objecten verzamelen
//$cursor_sort = $cursor_all->sort(array('price' => 1));                          // Sorteren volgens prijs

//foreach ($cursor_sort as $document) {                                           //for-les voor alle objecten uit de DB ziichtbaar te maken
  //echo 'Name: '.$document["name"]."<br />";
    //echo 'Price: '.$document["price"]."€ <br />";
  //echo "<br />";
//}
