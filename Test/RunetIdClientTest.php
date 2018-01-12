<?php

namespace RunetId\Client\Test;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\HttpClient\PaginatedHttpClient;

class RunetIdClientTest extends TestCase
{
    public function testDecodeResponse()
    {
        $data = ['a' => 1, 'b' => ['x' => 'y']];
        $response = MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($data));

        $httpClient = new Client();
        $httpClient->addResponse($response);

        $client = new RunetIdClient($httpClient);

        $actual = $client->request(MessageFactoryDiscovery::find()->createRequest('GET', '/'));
        $this->assertSame($data, $actual);
    }

    /**
     * @expectedException \RunetId\Client\Exception\JsonDecodeException
     * @expectedExceptionMessage Syntax error
     * @expectedExceptionCode    4
     */
    public function testDecodeResponseException()
    {
        $response = MessageFactoryDiscovery::find()->createResponse(200, null, [], 'non-json');

        $httpClient = new Client();
        $httpClient->addResponse($response);

        $client = new RunetIdClient($httpClient);

        $client->request(MessageFactoryDiscovery::find()->createRequest('GET', '/'));
    }

    /**
     * @expectedException \RunetId\Client\Exception\ApiErrorException
     */
    public function testDetectError()
    {
        $response = MessageFactoryDiscovery::find()->createResponse(200, null, [], '{"Error":""}');

        $httpClient = new Client();
        $httpClient->addResponse($response);

        $client = new RunetIdClient($httpClient);

        $client->request(MessageFactoryDiscovery::find()->createRequest('GET', '/'));
    }

    /**
     * @dataProvider getRequestPaginatedParams
     */
    public function testRequestPaginated($total, $limit, $expectedItemsCount, $expectedRequestsCount)
    {
        $httpClient = new PaginatedHttpClient('Users', $total);
        $client = new RunetIdClient($httpClient);

        $request = MessageFactoryDiscovery::find()->createRequest('GET', '/');

        $data = $client->requestPaginated($request, 'Users', $limit);

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
