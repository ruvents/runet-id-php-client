<?php

namespace RunetId\Client\Test\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Test\ClientTestTrait;
use RunetId\Client\Test\Fixtures\Endpoint\SuccessTestEndpoint;

final class SuccessTraitTest extends TestCase
{
    use ClientTestTrait;

    public function test()
    {
        $this->httpClient->addResponse(new Response(200, [], '{"Success":true}'));

        $result = (new SuccessTestEndpoint($this->client))
            ->getResult();

        $this->assertTrue($result->Success);
    }
}
