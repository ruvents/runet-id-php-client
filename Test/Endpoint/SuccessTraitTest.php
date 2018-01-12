<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use RunetId\Client\RunetIdClient;
use RunetId\Client\Test\Fixtures\Endpoint\SuccessTestEndpoint;

final class SuccessTraitTest extends TestCase
{
    public function test()
    {
        $httpClient = new Client();
        $httpClient->addResponse(new Response(200, [], '{"Success":true}'));

        $client = new RunetIdClient($httpClient);

        $result = (new SuccessTestEndpoint($client))
            ->getResult();

        $this->assertTrue($result->Success);
    }
}
