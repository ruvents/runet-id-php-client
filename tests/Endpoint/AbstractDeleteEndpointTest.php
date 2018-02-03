<?php

namespace RunetId\Client\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\ClientTestTrait;

final class AbstractDeleteEndpointTest extends TestCase
{
    use ClientTestTrait;

    public function test()
    {
        $this->httpClient->addResponse(new Response(200, [], '{"Success":true}'));

        $endpoint = $this->getMockForAbstractClass(AbstractDeleteEndpoint::class, [$this->client]);
        $endpoint->method('getEndpoint')->willReturn('/test');

        $result = $endpoint->getResult();

        $request = $this->httpClient->getLastRequest();

        $this->assertTrue($result->Success);
        $this->assertSame('DELETE', $request->getMethod());
    }
}
