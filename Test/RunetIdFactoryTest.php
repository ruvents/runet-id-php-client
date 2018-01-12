<?php

namespace RunetId\Client\Test;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdFactory;

final class RunetIdFactoryTest extends TestCase
{
    public function testRequestPlugins()
    {
        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], 'null'));

        $client = RunetIdFactory::createClient('key', 'secret', 'https://host.com/test?a=1&b=2', [], $httpClient);

        $client->request(new Request('GET', '/method?a=2'));

        $request = $httpClient->getLastRequest();

        $this->assertSame('https', $request->getUri()->getScheme());
        $this->assertSame('host.com', $request->getUri()->getHost());
        $this->assertSame('/test/method', $request->getUri()->getPath());
        $this->assertSame('a=2&b=2', $request->getUri()->getQuery());
        $this->assertSame('key', $request->getHeaderLine('Apikey'));
    }

    /**
     * @expectedException \Http\Client\Common\Exception\ServerErrorException
     */
    public function testErrorPlugin()
    {
        $httpClient = new Client();
        $httpClient->addResponse(new Response(500));

        $client = RunetIdFactory::createClient('key', 'secret', 'http://host.com', [], $httpClient);

        $client->request(new Request('GET', '/'));
    }
}
