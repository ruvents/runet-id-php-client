<?php

namespace RunetId\Client\Test;

use Http\Mock\Client;
use RunetId\Client\RunetIdClient;

trait RunetIdClientTestTrait
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
