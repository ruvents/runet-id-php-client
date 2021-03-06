<?php

namespace RunetId\Client;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Exception\JsonDecodeException;
use RunetId\Client\Exception\RunetIdException;
use RunetId\Client\Fixtures\HttpClient\PaginatedHttpClient;

final class RunetIdClientTest extends TestCase
{
    use ClientTestTrait;

    public function testGenerateOAuthUri()
    {
        $this->assertSame(
            RunetIdClientFactory::OAUTH_URI.'?apikey=key&url=url',
            $this->client->generateOAuthUri('url')
        );
    }

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
    public function testRequestPaginated($total, $maxResults, $expectedItemsCount, $expectedRequestsCount)
    {
        $httpClient = new PaginatedHttpClient($total);
        $factory = new RunetIdClientFactory($httpClient);
        $client = $factory->create('key', 'secret');

        $query = http_build_query(['MaxResults' => $maxResults], '', '&');
        $data = $client->requestPaginated(new Request('GET', '/?'.$query), 'Items');

        $expectedItems = $expectedItemsCount <= 0 ? [] : range(1, $expectedItemsCount);

        $this->assertInstanceOf(\Generator::class, $data['Items']);
        $items = iterator_to_array($data['Items']);

        $this->assertCount($expectedRequestsCount, $httpClient->getRequests());
        $this->assertCount($expectedItemsCount, $items);
        $this->assertSame($expectedItems, $items);
    }

    public function getRequestPaginatedParams()
    {
        yield [0, 0, 0, 1];
        yield [10, 0, 0, 1];
        yield [10, 3, 3, 1];
        yield [10, 10, 10, 1];
        yield [10, 1000, 10, 1];
        yield [10, null, 10, 1];
        yield [1000, 1000, 1000, 5];
        yield [1000, 1004, 1000, 6];
        yield [1000, 211, 211, 2];
        yield [1000, null, 1000, 6];
        yield [1000, -1, 1000, 1];
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

    public function testMagicEndpointCalls()
    {
        /** @var Method[] $methods */
        $methods = DocBlockFactory::createInstance()
            ->create((new \ReflectionClass($this->client))->getDocComment())
            ->getTagsByName('method');

        foreach ($methods as $method) {
            $name = $method->getMethodName();

            /** @var Object_ $type */
            $type = $method->getReturnType();
            $class = 'RunetId\Client'.$type->getFqsen();

            $this->assertInstanceOf($class, $this->client->$name());
        }
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method RunetId\Client\RunetIdClient::nonExistingMethod() is not defined.
     */
    public function testMagicCallException()
    {
        $this->client->nonExistingMethod();
    }

    /**
     * @expectedException \RunetId\Client\Exception\UnexpectedPaginatedDataException
     * @expectedExceptionMessage Paginated data is expected to be an array.
     */
    public function testRequestPaginatedNotArrayException()
    {
        $this->httpClient->addResponse(new Response(200, [], 'null'));
        $this->client->requestPaginated(new Request('GET', '/'), 'Items');
    }

    /**
     * @expectedException \RunetId\Client\Exception\UnexpectedPaginatedDataException
     * @expectedExceptionMessage The result array does not contain key "Items".
     */
    public function testRequestPaginatedNoKeyException()
    {
        $this->httpClient->addResponse(new Response(200, [], '[]'));
        $this->client->requestPaginated(new Request('GET', '/'), 'Items');
    }
}
