<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use RunetId\ApiClient\Api;
use RunetId\ApiClient\Client;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

require_once __DIR__.'/vendor/autoload.php';
$config = require_once __DIR__.'/config.php';

$client = new Client($config);
$serializer = new Serializer(
    [new ObjectNormalizer(), new ArrayDenormalizer()],
    [new JsonEncoder()]
);
$api = new Api($client, $serializer);

var_dump($api->getEventSectionList());
