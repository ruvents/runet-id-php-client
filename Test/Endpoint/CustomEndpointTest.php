<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\Result\TestResult;

final class CustomEndpointTest extends TestCase
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
        $this->httpClient->setDefaultResponse(new Response(200, [], '[]'));

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

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Endpoint was not set. Use setEndpoint().
     */
    public function testNoEndpointException()
    {
        $this->client->custom()
            ->getResult();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Class was not set. Use setClass().
     */
    public function testNoClassException()
    {
        $this->client->custom()
            ->setEndpoint('/test')
            ->getResult();
    }
}
