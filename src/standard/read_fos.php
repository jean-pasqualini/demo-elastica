<?php

namespace App;

use Elastica\Client;
use Elastica\Document;
use Elastica\Search;
use Elastica\Type\Mapping;

require_once __DIR__.'/vendor/autoload.php';

function step($title) {
    echo' ======================  '.$title.' =========================='.PHP_EOL;
}

$client = new Client([
    'host' => 'localhost',
    'port' => 9200,
]);

// Search document
step ('Search document');

$search = new Search($client);

$search
    ->addIndex('app')
    ->addType('product');


step('Raw query');
var_dump($search->getQuery()->toArray());

$resultSet = $search->search();

step ('Result set');
foreach ($resultSet as $result) {
    var_dump($result->getData());
}

step ('count result');
var_dump($search->count());


step ('index names');
var_dump($client->getStatus()->getIndexNames());

echo 'hello world';