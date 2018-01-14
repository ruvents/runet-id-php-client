<?php

namespace RunetId\Client\Test\Result;

use PHPUnit\Framework\TestCase;
use RunetId\Client\Test\Fixtures\Result\TestResult;

final class AbstractResultTest extends TestCase
{
    public function testMagicPropertyAccess()
    {
        $result = new TestResult(['Id' => 1, 'Name' => null]);

        $this->assertTrue($result->exists('Id'));
        $this->assertTrue(isset($result->Id));
        $this->assertNotEmpty($result->Id);
        $this->assertSame(1, $result->Id);

        $this->assertTrue($result->exists('Name'));
        $this->assertFalse(isset($result->Name));
        $this->assertEmpty($result->Name);
        $this->assertNull($result->Name);

        $this->assertFalse($result->exists('Collection'));
        $this->assertFalse(isset($result->Collection));
        $this->assertEmpty($result->Collection);
    }

    public function testIterator()
    {
        $data = ['Id' => 1, 'Name' => null];
        $this->assertSame($data, iterator_to_array(new TestResult($data)));
    }

    /**
     * @expectedException \OutOfBoundsException
     * @expectedExceptionMessage Offset "Id" does not exist in the result array. The result array is empty.
     */
    public function testMagicGetOffsetFromEmptyException()
    {
        (new TestResult([]))->Id;
    }

    /**
     * @expectedException \OutOfBoundsException
     * @expectedExceptionMessage Offset "Id" does not exist in the result array. "Collection" offset is available.
     */
    public function testMagicGetOffsetFromSingleOffsetException()
    {
        (new TestResult(['Collection' => []]))->Id;
    }

    /**
     * @expectedException \OutOfBoundsException
     * @expectedExceptionMessage Offset "Id" does not exist in the result array. "Collection", "Name" offsets are available.
     */
    public function testMagicGetOffsetFromMultipleOffsetsException()
    {
        (new TestResult(['Collection' => [], 'Name' => 'name']))->Id;
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Result is immutable.
     */
    public function testMagicSetException()
    {
        $result = new TestResult([]);
        $result->Id = 1;
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Result is immutable.
     */
    public function testMagicUnsetException()
    {
        $result = new TestResult([]);
        unset($result->Id);
    }
}
