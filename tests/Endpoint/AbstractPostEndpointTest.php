<?php

namespace RunetId\Client\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\ClientTestTrait;

final class AbstractPostEndpointTest extends TestCase
{
    use ClientTestTrait;

    public function testFormSetters()
    {
        $this->httpClient->addResponse(new Response(200, [], 'null'));

        $endpoint = $this->getMockForAbstractClass(AbstractPostEndpoint::class, [$this->client]);
        $endpoint->method('getEndpoint')->willReturn('/test');

        $endpoint
            ->setFormData([
                'a' => 1,
                'b' => 1,
                'c' => 2,
            ])
            ->setFormValue('b', 2)
            ->addFormData([
                'c' => 3,
                'd' => 4,
            ])
            // test magic setter
            ->setE(5)
            ->setLanguage('en')
            ->getRawResult();

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('/test', $request->getUri()->getPath());
        $this->assertSame('Language=en', $request->getUri()->getQuery());
        $this->assertSame('a=1&b=2&c=3&d=4&E=5', (string) $request->getBody());
        $this->assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
    }
}
