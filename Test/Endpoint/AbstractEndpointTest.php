<?php

namespace RunetId\Client\Test\Endpoint;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\Result\TestResult;

class AbstractEndpointTest extends TestCase
{
    public function testQuerySetters()
    {
        $httpClient = new Client();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], 'null'));

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

        $response = MessageFactoryDiscovery::find()->createResponse(200, null, [], json_encode($data));

        $httpClient = new Client();
        $httpClient->addResponse($response);

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
     */
    public function testNonSetterException()
    {
        $this->getMockForAbstractClass(AbstractEndpoint::class, [], '', false)
            ->nonSetterMethod();
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testZeroArgumentsException()
    {
        $this->getMockForAbstractClass(AbstractEndpoint::class, [], '', false)
            ->setSomething();
    }
}
