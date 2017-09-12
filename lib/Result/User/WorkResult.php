<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\Result\AbstractResult;
use RunetId\ApiClient\Result\Company\CompanyResult;

/**
 * @property null|string        $Position
 * @property null|CompanyResult $Company
 * @property null|int           $StartYear
 * @property null|int           $StartMonth
 * @property null|int           $EndYear
 * @property null|int           $EndMonth
 */
class WorkResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Company' => 'RunetId\ApiClient\Result\Company\CompanyResult',
        ];
    }
}
