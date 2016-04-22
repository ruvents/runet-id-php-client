<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\ApiException;

require_once __DIR__.'/../vendor/autoload.php';
$config = require_once __DIR__.'/Fixtrures/config.php';

$apiClient = new ApiClient($config);

try {
    //var_dump($apiClient->get('user/get', ['RunetId' => 488031])->jsonDecode());
    /*var_dump($apiClient->get('competence/tests')->jsonDecode());
    var_dump($apiClient->get('competence/result', ['RunetId' => 471434, 'TestId' => 48])->jsonDecode());
    var_dump($apiClient->get('competence/result', ['RunetId' => 471434, 'TestId' => 49])->jsonDecode());*/
    $call = $apiClient->get('user/get', ['RunetId' => 490724]);

    var_dump($call->jsonDecode(), $call->getRawBody());
    //var_dump($apiClient->get('event/info')->jsonDecode(true));
} catch (ApiException $error) {
    echo sprintf('Error %s: %s.', $error->getCode(), $error->getMessage());
}
