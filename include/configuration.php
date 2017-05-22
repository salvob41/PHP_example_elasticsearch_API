<?php
/**
 * Created by PhpStorm.
 * User: salvob
 * Date: 22/05/2017
 * Time: 15:01
 */

require dirname(__DIR__) . "/vendor/autoload.php";;
use Elasticsearch\ClientBuilder;


//get configuration from file
$config = parse_ini_file(dirname(__DIR__) . "/include/conf.ini");

$hosts = [
    [
        'host' => $config["host"],    // Only host is required
    ]
];
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('name');
$logger->pushHandler(new StreamHandler(dirname(__DIR__) . '/log/elastic.log', Logger::INFO));
$client = ClientBuilder::create()
    ->setLogger($logger)
    ->setHosts($hosts)
    ->build();

define("INDEX_NAME", $config["index"]);
