<?php

namespace RunetId\Client\Test\Result;

use PHPUnit\Framework\TestCase;
use RunetId\Client\Result\ResultFactory;
use RunetId\Client\Test\Fixtures\Result\TestResult;

class ResultFactoryTest extends TestCase
{
    public function testCreate()
    {
        $data = ['Id' => 1];

        /** @var TestResult $result */
        $result = ResultFactory::create($data, TestResult::class);

        $this->assertInstanceOf(TestResult::class, $result);
        $this->assertSame(1, $result->Id);
    }

    public function testCreateArray()
    {
        $data = [
            'a' => [
                ['Id' => 1],
                ['Id' => 2],
            ],
            'b' => [
                ['Id' => 3],
                'x' => ['Id' => 4],
                ['Id' => 5],
            ],
        ];

        /** @var TestResult[][] $result */
        $result = ResultFactory::create($data, TestResult::class.'[][]');

        $this->assertSameSize($data, $result);
        $this->assertSame(array_keys($data), array_keys($result));

        foreach ($data as $key => $dataValue) {
            $resultValue = $result[$key];

            $this->assertSameSize($dataValue, $resultValue);
            $this->assertSame(array_keys($dataValue), array_keys($resultValue));

            foreach ($dataValue as $itemKey => $itemData) {
                $this->assertSame($itemData['Id'], $resultValue[$itemKey]->Id);
            }
        }
    }

    public function testMap()
    {
        $collectionData = [[], []];

        /** @var TestResult $result */
        $result = ResultFactory::create(['Collection' => $collectionData], TestResult::class);

        $this->assertSameSize($collectionData, $result->Collection);
        $this->assertContainsOnlyInstancesOf(TestResult::class, $result->Collection);
    }

    public function testNonExistingClass()
    {
        $this->expectException(\InvalidArgumentException::class);

        ResultFactory::create([], 'NS\NonExistingClass');
    }

    public function testInvalidClass()
    {
        $this->expectException(\InvalidArgumentException::class);

        ResultFactory::create([], self::class);
    }
}
