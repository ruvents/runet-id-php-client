<?php

namespace RunetId\Client\OAuth;

use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;

class OAuthUriGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $generator = new OAuthUriGenerator(new Uri('http://localhost:90'), 'key');

        $this->assertSame(
            'http://localhost:90?apikey=key&url=url',
            $generator->generate('url')
        );
    }
}
