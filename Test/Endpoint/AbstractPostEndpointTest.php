<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\RunetIdClient;

final class AbstractPostEndpointTest extends TestCase
{
    public function testFormSetters()
    {
        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], 'null'));

        $client = new RunetIdClient($httpClient);

        $endpoint = $this->getMockForAbstractClass(AbstractPostEndpoint::class, [$client]);
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

        $request = $httpClient->getLastRequest();
        $this->assertSame('/test', $request->getUri()->getPath());
        $this->assertSame('Language=en', $request->getUri()->getQuery());
        $this->assertSame('a=1&b=2&c=3&d=4&E=5', (string) $request->getBody());
        $this->assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
    }
}
