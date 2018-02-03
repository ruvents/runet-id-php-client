<?php

namespace RunetId\Client\Endpoint;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use RunetId\Client\ClientTestTrait;
use RunetId\Client\Fixtures\Endpoint\SuccessTestEndpoint;

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
