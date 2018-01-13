<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Test\ClientTestTrait;
use RunetId\Client\Test\Fixtures\Result\TestResult;

final class CustomEndpointTest extends TestCase
{
    use ClientTestTrait;

    public function test()
    {
        $this->httpClient->addResponse(new Response(200, [], '[]'));

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
        $this->httpClient->addResponse(new Response(200, [], '[]'));

        $this->client
            ->custom()
            ->getResult();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Class was not set. Use setClass().
     */
    public function testNoClassException()
    {
        $this->httpClient->addResponse(new Response(200, [], '[]'));

        $this->client
            ->custom()
            ->setEndpoint('/test')
            ->getResult();
    }
}
