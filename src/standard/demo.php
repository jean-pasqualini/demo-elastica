<?php

namespace App;

use Elastica\Client;
use Elastica\Document;
use Elastica\Search;
use Elastica\Type\Mapping;

$autoloader = require_once __DIR__.'/vendor/autoload.php';

function step($title) {
    echo' ======================  '.$title.' =========================='.PHP_EOL;
}

$client = new Client([
    'host' => 'localhost',
    'port' => 9200,
]);

// Create index
step('Create index');

$elasticaIndex = $client->getIndex('twitter');

$elasticaIndex->create([
    'number_of_shards' => 4,
    'number_of_replicas' => 1,
    'analysis' => [
        'analyzer' => [
            'default' => [
                'type' => 'custom',
                'tokenizer' => 'standard',
                'filter' => ['lowercase', 'mySnowball']
            ],
            'default_search' => [
                'type' => 'custom',
                'tokenizer' => 'standard',
                'filter' => ['standard', 'lowercase', 'mySnowball']
            ],
        ],
        'filter' => [
            'mySnowball' => [
                'type' => 'snowball',
                'language' => 'German',
            ]
        ]
    ]
], true);

// Create type
step('Create Type');

$elasticaType = $elasticaIndex->getType('twitter');

$mapping = new Mapping();

$mapping->setType($elasticaType);

$mapping->setProperties([
    'id' => ['type' => 'integer', 'include_in_all' => false],
    'user' => [
        'type' => 'object',
        'properties' => [
            'name' => ['type' => 'keyword', 'include_in_all' => true],
            'fullName' => ['type' => 'keyword', 'include_in_all' => true, 'boost' => 2],
        ],
    ],
    'msg' => ['type' => 'text', 'include_in_all' => true],
    'tstamp' => ['type' => 'date', 'include_in_all' => false],
    'location' => ['type' => 'geo_point', 'include_in_all' => false],
]);

$mapping->send();

// Index document
step ('Index document');

$id = 1;

$tweet = [
    'id' => $id,
    'user'    => [
        'name'      => 'mewantcookie',
        'fullName'  => 'Cookie Monster'
    ],
    'msg'     => 'Me wish there were expression for cookies like there is for apples. "A cookie a day make the doctor diagnose you with diabetes" not catchy.',
    'tstamp'  => '1238081389',
    'location'=> '41.12,-71.34',
    'float' => 2.3,
    'long' => 2.23231232132,
];

$tweetDocument = new Document($id, $tweet);

$elasticaType->addDocument($tweetDocument);

$elasticaType->getIndex()->refresh();

// Search document
step ('Search document');

$search = new Search($client);

$search
    ->addIndex('twitter')
    ->addType('twitter');


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

step('Mapping');
var_dump($elasticaIndex->getMapping());

echo 'hello world';