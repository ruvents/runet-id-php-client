<?php

namespace RunetId\Client\Test\Endpoint;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\Result\TestResult;

class CustomEndpointTest extends TestCase
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var RunetIdClient
     */
    private $client;

    protected function setUp()
    {
        $this->httpClient = new Client();
        $this->httpClient->setDefaultResponse(MessageFactoryDiscovery::find()
            ->createResponse(200, null, [], '[]'));

        $this->client = new RunetIdClient($this->httpClient);
    }

    public function test()
    {
        $result = $this->client
            ->custom()
            ->setMethod('PUT')
            ->setEndpoint('/test')
            ->setClass(TestResult::class)
            ->getResult();

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('PUT', $request->getMethod());
        $this->assertSame('/test', $request->getUri()->getPath());
        $this->assertInstanceOf(TestResult::class, $result);
    }

    public function testNoEndpointException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Endpoint was not set. Use setEndpoint().');

        $this->client->custom()
            ->getResult();
    }

    public function testNoClassException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Class was not set. Use setClass().');

        $this->client->custom()
            ->setEndpoint('/test')
            ->getResult();
    }
}
