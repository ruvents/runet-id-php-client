<?php

namespace RunetId\Client;

use Http\Mock\Client;

/**
 * @internal
 */
trait ClientTestTrait
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var RunetIdClient
     */
    protected $client;

    protected function setUp()
    {
        $this->httpClient = new Client();
        $factory = new RunetIdClientFactory($this->httpClient);
        $this->client = $factory->create('key', 'secret');
    }
}
