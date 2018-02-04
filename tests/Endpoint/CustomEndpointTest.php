<?php

namespace RunetId\Client\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\ClientTestTrait;
use RunetId\Client\Fixtures\Result\TestResult;
use RunetId\Client\RunetIdClientFactory;

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

    public function testPaginated()
    {
        $this->httpClient->addResponse(new Response(200, [], '{"Items": []}'));

        $result = $this->client
            ->custom()
            ->setEndpoint('/test')
            ->setPaginated()
            ->setItemsKey('Items')
            ->setMaxResults(10)
            ->getRawResult();

        $request = $this->httpClient->getLastRequest();

        $this->assertSame(RunetIdClientFactory::API_URI.'/test?MaxResults=10', (string) $request->getUri());
        $this->assertInstanceOf(\Generator::class, $result['Items']);
    }

    public function testGetHasNoBody()
    {
        $this->httpClient->addResponse(new Response(200, [], '[]'));

        $this->client
            ->custom()
            ->setMethod('GET')
            ->setEndpoint('/test')
            ->setFormData(['a' => 1])
            ->getRawResult();

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('', (string) $request->getBody());
        $this->assertSame('', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Endpoint was not set. Use setEndpoint().
     */
    public function testNoEndpointException()
    {
        $this->client
            ->custom()
            ->getRawResult();
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

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Paginated items key was not set. Use setItemsKey().
     */
    public function testPaginatedNoItemsKeyException()
    {
        $this->client
            ->custom()
            ->setPaginated()
            ->setEndpoint('/test')
            ->getRawResult();
    }
}
