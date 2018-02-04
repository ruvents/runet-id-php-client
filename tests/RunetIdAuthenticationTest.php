<?php

namespace RunetId\Client;

use GuzzleHttp\Psr7\Request;
use phpmock\MockBuilder;
use PHPUnit\Framework\TestCase;

final class RunetIdAuthenticationTest extends TestCase
{
    public function test()
    {
        $key = 'key';
        $secret = 'secret';
        $time = time();

        (new MockBuilder())
            ->setNamespace('RunetId\Client\HttpClient')
            ->setName('time')
            ->setFunction(function () use ($time) {
                return $time;
            })
            ->build()
            ->enable();

        $request = new Request('GET', '/', ['Apikey' => 'apikey', 'Timestamp' => 0, 'Hash' => 'hash']);

        $request = (new RunetIdAuthentication($key, $secret))
            ->authenticate($request);

        $this->assertSame($key, $request->getHeaderLine('Apikey'));
        $this->assertSame((string) $time, $request->getHeaderLine('Timestamp'));
        $this->assertSame(substr(md5($key.$time.$secret), 0, 16), $request->getHeaderLine('Hash'));
    }
}
