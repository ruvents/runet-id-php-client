<?php

namespace RunetId\Client\Test\Endpoint;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\AbstractPaginatedEndpoint;
use RunetId\Client\RunetIdClient;

class AbstractPaginatedEndpointTest extends TestCase
{
    public function test()
    {
        $offset = 'Items';
        $data = [$offset => [['Id' => 1]]];

        $httpClient = new Client();
        $httpClient->addResponse(MessageFactoryDiscovery::find()
            ->createResponse(200, null, [], json_encode($data)));

        $client = new RunetIdClient($httpClient);

        $endpoint = $this->getMockForAbstractClass(AbstractPaginatedEndpoint::class, [$client]);
        $endpoint->method('getEndpoint')->willReturn('/test');
        $endpoint->method('getOffset')->willReturn($offset);

        $result = $endpoint->setLimit(1)
            ->getRawResult();

        $this->assertSame($data, $result);

        $request = $httpClient->getLastRequest();

        $this->assertSame('MaxResults=1', $request->getUri()->getQuery());
    }
}
