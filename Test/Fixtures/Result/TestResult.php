<?php

namespace RunetId\Client\Test\Fixtures\Result;

use RunetId\Client\Result\AbstractResult;

/**
 * @property int          $Id
 * @property string       $Name
 * @property TestResult[] $Collection
 */
final class TestResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Collection' => self::class.'[]',
        ];
    }
}
