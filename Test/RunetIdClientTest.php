<?php

namespace RunetId\Client\Test;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Exception\JsonDecodeException;
use RunetId\Client\Exception\RunetIdException;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\HttpClient\PaginatedHttpClient;

final class RunetIdClientTest extends TestCase
{
    use ClientTestTrait;

    public function testDecodeResponse()
    {
        $data = ['a' => 1, 'b' => ['x' => 'y']];

        $this->httpClient->addResponse(new Response(200, [], json_encode($data)));

        $actual = $this->client->request(new Request('GET', '/'));
        $this->assertSame($data, $actual);
    }

    public function testDecodeResponseException()
    {
        $invalidString = 'non-json';

        $this->httpClient->addResponse(new Response(200, [], $invalidString));

        try {
            $this->client->request(new Request('GET', '/'));
            $this->fail('No exception thrown.');
        } catch (JsonDecodeException $exception) {
            $this->assertSame('Syntax error', $exception->getMessage());
            $this->assertSame(JSON_ERROR_SYNTAX, $exception->getCode());
            $this->assertSame($invalidString, $exception->getInvalidString());
        }
    }

    /**
     * @dataProvider getErrorVariants
     */
    public function testDetectErrorNoErrorData(array $data, $expectedMessage, $expectedCode)
    {
        $this->httpClient->addResponse(new Response(200, [], json_encode($data)));

        try {
            $this->client->request(new Request('GET', '/'));
            $this->fail('No exception thrown.');
        } catch (RunetIdException $exception) {
            $this->assertSame($data, $exception->getData());
            $this->assertSame($expectedMessage, $exception->getMessage());
            $this->assertSame($expectedCode, $exception->getCode());
        }
    }

    public function getErrorVariants()
    {
        yield [['Error' => [], 'SomeData' => 1], '', 0];
        yield [['Error' => ['Code' => 1], 'SomeData' => 1], '', 1];
        yield [['Error' => ['Message' => 'Fail']], 'Fail', 0];
    }

    /**
     * @dataProvider getRequestPaginatedParams
     */
    public function testRequestPaginated($total, $limit, $expectedItemsCount, $expectedRequestsCount)
    {
        $httpClient = new PaginatedHttpClient('Users', $total);
        $client = new RunetIdClient($httpClient);

        $data = $client->requestPaginated(new Request('GET', '/'), 'Users', $limit);

        $this->assertCount($expectedRequestsCount, $httpClient->getRequests());
        $this->assertCount($expectedItemsCount, $data['Users']);
        $this->assertSame(0 === $expectedItemsCount ? [] : range(1, $expectedItemsCount), $data['Users']);
    }

    public function getRequestPaginatedParams()
    {
        yield [0, 0, 0, 1];
        yield [10, 0, 0, 1];
        yield [10, 3, 3, 1];
        yield [10, 10, 10, 1];
        yield [10, 1000, 10, 1];
        yield [10, -1, 10, 1];
        yield [1000, 1000, 1000, 5];
        yield [1000, 1004, 1000, 5];
        yield [1000, 201, 201, 2];
        yield [1000, -1, 1000, 5];
    }

    /**
     * @dataProvider getEndpointMethods
     */
    public function testGetEndpointClass($method, $expectedClass)
    {
        $getEndpointClass = new \ReflectionMethod($this->client, 'getEndpointClass');
        $getEndpointClass->setAccessible(true);

        $this->assertSame($expectedClass, $getEndpointClass->invoke($this->client, $method));
    }

    public function getEndpointMethods()
    {
        yield ['user', 'RunetId\Client\Endpoint\UserEndpoint'];
        yield ['userGet', 'RunetId\Client\Endpoint\User\GetEndpoint'];
        yield ['userGetPost', 'RunetId\Client\Endpoint\User\GetPostEndpoint'];
    }

    public function testMagicCall()
    {
        $class = 'RunetId\Client\Endpoint\Test\GetEndpoint';
        $this->getMockBuilder($class)->getMock();

        $this->assertInstanceOf($class, $this->client->testGet());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method RunetId\Client\RunetIdClient::nonExistingMethod() is not defined.
     */
    public function testMagicCallException()
    {
        $this->client->nonExistingMethod();
    }
}
