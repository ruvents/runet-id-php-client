<?php

namespace RunetId\Client\Test;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Exception\RunetIdException;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\HttpClient\PaginatedHttpClient;

final class RunetIdClientTest extends TestCase
{
    public function testDecodeResponse()
    {
        $data = ['a' => 1, 'b' => ['x' => 'y']];

        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], json_encode($data)));

        $client = new RunetIdClient($httpClient);

        $actual = $client->request(new Request('GET', '/'));
        $this->assertSame($data, $actual);
    }

    /**
     * @expectedException \RunetId\Client\Exception\JsonDecodeException
     * @expectedExceptionMessage Syntax error
     * @expectedExceptionCode    4
     */
    public function testDecodeResponseException()
    {
        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], 'non-json'));

        $client = new RunetIdClient($httpClient);

        $client->request(new Request('GET', '/'));
    }

    /**
     * @dataProvider getErrorVariants
     */
    public function testDetectErrorNoErrorData(array $data, $expectedMessage, $expectedCode)
    {
        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], json_encode($data)));

        try {
            (new RunetIdClient($httpClient))
                ->request(new Request('GET', '/'));

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
        return [
            [0, 0, 0, 1],
            [10, 0, 0, 1],
            [10, 3, 3, 1],
            [10, 10, 10, 1],
            [10, 1000, 10, 1],
            [10, -1, 10, 1],
            [1000, 1000, 1000, 5],
            [1000, 1004, 1000, 5],
            [1000, 201, 201, 2],
            [1000, -1, 1000, 5],
        ];
    }

    /**
     * @dataProvider getEndpointMethods
     */
    public function testGetEndpointClass($method, $expectedClass)
    {
        $client = new RunetIdClient(new Client());
        $getEndpointClass = new \ReflectionMethod($client, 'getEndpointClass');
        $getEndpointClass->setAccessible(true);

        $this->assertSame($expectedClass, $getEndpointClass->invoke($client, $method));
    }

    public function getEndpointMethods()
    {
        return [
            ['user', 'RunetId\Client\Endpoint\UserEndpoint'],
            ['userGet', 'RunetId\Client\Endpoint\User\GetEndpoint'],
            ['userGetPost', 'RunetId\Client\Endpoint\User\GetPostEndpoint'],
        ];
    }

    public function testMagicCall()
    {
        $class = 'RunetId\Client\Endpoint\Test\GetEndpoint';
        $this->getMockBuilder($class)->getMock();

        $client = new RunetIdClient(new Client());

        $this->assertInstanceOf($class, $client->testGet());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testMagicCallException()
    {
        $client = new RunetIdClient(new Client());
        $client->nonExistingMethod();
    }
}
