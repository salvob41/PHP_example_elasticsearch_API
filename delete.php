<?php
require 'vendor/autoload.php';
require_once __DIR__ . "/include/configuration.php";

$params = [
    'index' => INDEX_NAME,
    'type' => 'my_type',
    'id' => '1'
];

//$response = $client->delete($params);
print_r($response);