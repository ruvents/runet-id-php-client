<?php

namespace RunetId\Client\Test\Endpoint;

use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\Endpoint\SuccessTestEndpoint;

class SuccessTraitTest extends TestCase
{
    public function test()
    {
        $httpClient = new Client();
        $httpClient->addResponse(MessageFactoryDiscovery::find()->createResponse(200, null, [], '{"Success":true}'));

        $client = new RunetIdClient($httpClient);

        $result = (new SuccessTestEndpoint($client))
            ->getResult();

        $this->assertTrue($result->Success);
    }
}
