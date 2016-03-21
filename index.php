<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\ApiException;

require_once __DIR__.'/vendor/autoload.php';
$config = require_once __DIR__.'/config.php';

$apiClient = new ApiClient($config);

try {
    $response = $apiClient->user(454)->get();
    var_dump($response);
} catch (ApiException $error) {
    echo sprintf('Error %s: %s.', $error->getCode(), $error->getMessage());
}
