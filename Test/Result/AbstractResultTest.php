<?php

namespace RunetId\Client\Test\Result;

use PHPUnit\Framework\TestCase;
use RunetId\Client\Test\Fixtures\Result\TestResult;

final class AbstractResultTest extends TestCase
{
    public function test()
    {
        $result = new TestResult(['Id' => 1, 'Name' => null]);

        $this->assertSame(1, $result->Id);
        $this->assertNull($result->Collection);

        $this->assertTrue(isset($result->Id));
        $this->assertFalse(isset($result->Name));
        $this->assertFalse(isset($result->Collection));

        $this->assertTrue($result->exists('Id'));
        $this->assertTrue($result->exists('Name'));
        $this->assertFalse($result->exists('Collection'));
    }
}
