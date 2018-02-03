<?php

namespace RunetId\Client\Result\User;

use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\Company\CompanyResult;

/**
 * @property null|string        $Position
 * @property null|CompanyResult $Company
 * @property null|int           $StartYear
 * @property null|int           $StartMonth
 * @property null|int           $EndYear
 * @property null|int           $EndMonth
 */
final class WorkResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Company' => CompanyResult::class,
        ];
    }
}
