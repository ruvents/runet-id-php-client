<?php

namespace RunetId\Client;

use PHPUnit\Framework\TestCase;

class RunetIdOAuthTest extends TestCase
{
    public function testGetOAuthUrl()
    {
        $this->assertSame(
            'https://runet-id.com/oauth/main/dialog?apikey=key&url=url',
            RunetIdOAuth::getUrl('key', 'url')
        );

        $this->assertSame(
            'localhost/oauth/main/dialog?apikey=key&url=url',
            RunetIdOAuth::getUrl('key', 'url', 'localhost/')
        );
    }
}
