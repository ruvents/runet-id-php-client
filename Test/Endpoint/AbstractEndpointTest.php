<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\Result\TestResult;

final class AbstractEndpointTest extends TestCase
{
    public function testQuerySetters()
    {
        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], 'null'));

        $client = new RunetIdClient($httpClient);

        $endpoint = $this->getMockForAbstractClass(AbstractEndpoint::class, [$client]);
        $endpoint->method('getEndpoint')->willReturn('/test');

        $endpoint
            ->setQueryData([
                'a' => 1,
                'b' => 1,
                'c' => 2,
            ])
            ->setQueryValue('b', 2)
            ->addQueryData([
                'c' => 3,
                'd' => 4,
            ])
            // test magic setter
            ->setE(5)
            ->setLanguage('en');

        $this->assertNull($endpoint->getRawResult());

        $request = $httpClient->getLastRequest();
        $this->assertSame('/test', $request->getUri()->getPath());
        $this->assertSame('a=1&b=2&c=3&d=4&E=5&Language=en', $request->getUri()->getQuery());
    }

    public function testGetResult()
    {
        $data = ['Id' => 1];

        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], json_encode($data)));

        $client = new RunetIdClient($httpClient);

        $endpoint = $this->getMockForAbstractClass(AbstractEndpoint::class, [$client]);
        $endpoint->method('getEndpoint')->willReturn('/test');
        $endpoint->method('getClass')->willReturn(TestResult::class);

        /** @var TestResult $result */
        $result = $endpoint->getResult();

        $this->assertInstanceOf(TestResult::class, $result);
        $this->assertSame(1, $result->Id);
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Only setter methods are supported, "nonSetterMethod" called.
     */
    public function testNonSetterException()
    {
        $this->getMockForAbstractClass(AbstractEndpoint::class, [], '', false)
            ->nonSetterMethod();
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessageRegExp /Method [\w\\]+::setSomething\(\) requires one argument./
     */
    public function testZeroArgumentsException()
    {
        $this->getMockForAbstractClass(AbstractEndpoint::class, [], '', false)
            ->setSomething();
    }
}
