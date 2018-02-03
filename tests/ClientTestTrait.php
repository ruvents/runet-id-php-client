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
        $this->client = new RunetIdClient($this->httpClient);
    }
}
