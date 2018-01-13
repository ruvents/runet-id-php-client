<?php

namespace RunetId\Client\Test;

use Http\Message\MessageFactory\GuzzleMessageFactory;
use Http\Message\StreamFactory\GuzzleStreamFactory;
use Http\Message\UriFactory\GuzzleUriFactory;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdClientFactory;

final class DependencyInjectionTest extends TestCase
{
    public function test()
    {
        $httpClient = new Client();
        $uriFactory = new GuzzleUriFactory();
        $requestFactory = new GuzzleMessageFactory();
        $streamFactory = new GuzzleStreamFactory();

        $factory = new RunetIdClientFactory($httpClient, $uriFactory, $requestFactory, $streamFactory);
        $client = $factory->create('key', 'secret');
        $endpoint = $client->custom();
        $bodyHelper = $this->getObjectAttribute($endpoint, 'bodyHelper');

        $this->assertAttributeSame($httpClient, 'httpClient', $factory);
        $this->assertAttributeSame($uriFactory, 'uriFactory', $factory);
        $this->assertAttributeSame($requestFactory, 'requestFactory', $factory);
        $this->assertAttributeSame($streamFactory, 'streamFactory', $factory);

        $this->assertAttributeSame($requestFactory, 'requestFactory', $client);
        $this->assertAttributeSame($streamFactory, 'streamFactory', $client);

        $this->assertAttributeSame($requestFactory, 'requestFactory', $endpoint);
        $this->assertAttributeSame($streamFactory, 'streamFactory', $endpoint);

        $this->assertAttributeSame($streamFactory, 'streamFactory', $bodyHelper);
    }
}
