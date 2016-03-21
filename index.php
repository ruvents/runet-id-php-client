<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use RunetId\ApiClient\ApiClient;

require_once __DIR__.'/vendor/autoload.php';
$config = require_once __DIR__.'/config.php';

$apiClient = new ApiClient($config);

var_dump($apiClient->user(454)->get());
