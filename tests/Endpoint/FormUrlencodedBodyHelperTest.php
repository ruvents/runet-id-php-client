<?php

namespace RunetId\Client\Endpoint;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

final class FormUrlencodedBodyHelperTest extends TestCase
{
    public function test()
    {
        $helper = (new FormUrlencodedBodyHelper())
            ->setData([
                'a' => 1,
                'b' => 1,
                'c' => 2,
            ])
            ->setValue('b', 2)
            ->addData([
                'c' => 3,
                'd' => 4,
            ]);

        $request = $helper->apply(new Request('GET', '/'));

        $this->assertSame($helper->getData(), ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $this->assertSame('a=1&b=2&c=3&d=4', (string) $request->getBody());
        $this->assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
    }
}
