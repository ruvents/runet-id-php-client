<?php

namespace RunetId\Client\Test;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdFactory;

class RunetIdFactoryTest extends TestCase
{
    public function testRequestPlugins()
    {
        $httpClient = new Client();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], 'null'));

        $client = RunetIdFactory::createClient('key', 'secret', 'https://host.com/test?a=1&b=2', [], $httpClient);

        $client->request(MessageFactoryDiscovery::find()->createRequest('GET', '/method?a=2'));

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
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(500));

        $client = RunetIdFactory::createClient('key', 'secret', 'http://host.com', [], $httpClient);

        $client->request(MessageFactoryDiscovery::find()->createRequest('GET', '/'));
    }
}
