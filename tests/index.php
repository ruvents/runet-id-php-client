<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\ApiException;

require_once __DIR__.'/../vendor/autoload.php';
$config = require_once __DIR__.'/Fixtrures/config.php';

$apiClient = new ApiClient($config);

try {
    var_dump($apiClient->section()->getByUser(483987));
} catch (ApiException $error) {
    echo sprintf('Error %s: %s.', $error->getCode(), $error->getMessage());
}
