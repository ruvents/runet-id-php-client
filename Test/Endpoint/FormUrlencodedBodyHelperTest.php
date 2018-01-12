<?php

namespace RunetId\Client\Test\Endpoint;

use Http\Discovery\MessageFactoryDiscovery;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\FormUrlencodedBodyHelper;

class FormUrlencodedBodyHelperTest extends TestCase
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

        $request = $helper->apply(MessageFactoryDiscovery::find()->createRequest('GET', '/'));

        $this->assertSame($helper->getData(), ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $this->assertSame('a=1&b=2&c=3&d=4', (string) $request->getBody());
        $this->assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
    }
}
