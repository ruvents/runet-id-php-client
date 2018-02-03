<?php

namespace RunetId\Client;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;

final class RunetIdClientFactoryTest extends TestCase
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var RunetIdClientFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->httpClient = new Client();
        $this->factory = new RunetIdClientFactory($this->httpClient);
    }

    public function testRequestPlugins()
    {
        $this->httpClient->addResponse(new Response(200, [], 'null'));

        $this->factory
            ->create('key', 'secret', 'https://host.com/test?a=1&b=2')
            ->request(new Request('GET', '/method?a=2'));

        $request = $this->httpClient->getLastRequest();

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
        $this->httpClient->addResponse(new Response(500));

        $this->factory
            ->create('key', 'secret', 'http://host.com')
            ->request(new Request('GET', '/'));
    }
}
