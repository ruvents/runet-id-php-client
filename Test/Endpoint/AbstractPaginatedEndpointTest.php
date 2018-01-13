<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\AbstractPaginatedEndpoint;
use RunetId\Client\Test\ClientTestTrait;

final class AbstractPaginatedEndpointTest extends TestCase
{
    use ClientTestTrait;

    public function test()
    {
        $offset = 'Items';
        $data = [$offset => [['Id' => 1]]];

        $this->httpClient->addResponse(new Response(200, [], json_encode($data)));

        $endpoint = $this->getMockForAbstractClass(AbstractPaginatedEndpoint::class, [$this->client]);
        $endpoint->method('getEndpoint')->willReturn('/test');
        $endpoint->method('getOffset')->willReturn($offset);

        $result = $endpoint->setLimit(1)
            ->getRawResult();

        $this->assertSame($data, $result);

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('MaxResults=1', $request->getUri()->getQuery());
    }
}
