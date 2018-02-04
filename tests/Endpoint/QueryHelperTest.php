<?php

namespace RunetId\Client\Endpoint;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

final class QueryHelperTest extends TestCase
{
    public function testParse()
    {
        $this->assertSame(['a' => '1', 'b' => '2'], QueryHelper::parse('a=1&b=2'));
    }

    public function testBuild()
    {
        $this->assertSame('a=1&b=2', QueryHelper::build(['a' => 1, 'b' => 2]));
    }

    public function testConstructFromArray()
    {
        $this->assertSame(['a' => '1'], (new QueryHelper(['a' => '1']))->getData());
    }

    public function testConstructFromString()
    {
        $this->assertSame(['a' => '1'], (new QueryHelper('a=1'))->getData());
    }

    public function testSetters()
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

        $request = $helper->applyToRequest(new Request('GET', '/?x=1'));

        $this->assertSame('a=1&b=2&c=3&d=4', (string)$helper);
        $this->assertSame($helper->getData(), ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]);
        $this->assertSame('x=1&a=1&b=2&c=3&d=4', $request->getUri()->getQuery());
        $this->assertSame(1, $helper->getValue('a'));
        $this->assertNull($helper->getValue('z'));
        $this->assertSame(10, $helper->getValue('z', 10));
    }
}
