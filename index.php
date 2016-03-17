<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use RunetId\ApiClient\Api\Api;
use RunetId\ApiClient\Client;

require_once __DIR__.'/vendor/autoload.php';
$config = require_once __DIR__.'/config.php';

$client = new Client($config);
$api = new Api($client);

var_dump($api->getUser(454));
