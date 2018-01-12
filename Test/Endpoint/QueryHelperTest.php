<?php

namespace RunetId\Client\Test\Endpoint;

use Http\Discovery\MessageFactoryDiscovery;
use PHPUnit\Framework\TestCase;
use RunetId\Client\Endpoint\QueryHelper;

class QueryHelperTest extends TestCase
{
    public function test()
    {
        $helper = (new QueryHelper())
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

        $request = $helper->apply(MessageFactoryDiscovery::find()->createRequest('GET', '/?x=1'));

        $this->assertSame($helper->getData(), ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $this->assertSame('x=1&a=1&b=2&c=3&d=4', $request->getUri()->getQuery());
    }
}
