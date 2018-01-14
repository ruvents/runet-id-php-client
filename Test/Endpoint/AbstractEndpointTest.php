<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Test\ClientTestTrait;
use RunetId\Client\Test\Fixtures\Result\TestResult;

final class AbstractEndpointTest extends TestCase
{
    use ClientTestTrait;

    public function testQuerySetters()
    {
        $this->httpClient->addResponse(new Response(200, [], 'null'));

        $endpoint = $this->getMockForAbstractClass(AbstractEndpoint::class, [$this->client]);
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

        $request = $this->httpClient->getLastRequest();

        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('/test', $request->getUri()->getPath());
        $this->assertSame('a=1&b=2&c=3&d=4&E=5&Language=en', $request->getUri()->getQuery());
    }

    public function testGetResult()
    {
        $data = ['Id' => 1];

        $this->httpClient->addResponse(new Response(200, [], json_encode($data)));

        $endpoint = $this->getMockForAbstractClass(AbstractEndpoint::class, [$this->client]);
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
