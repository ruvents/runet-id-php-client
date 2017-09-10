<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\Result\AbstractResult;
use RunetId\ApiClient\Result\Company\Company;

/**
 * @property null|string  $Position
 * @property null|Company $Company
 * @property null|int     $StartYear
 * @property null|int     $StartMonth
 * @property null|int     $EndYear
 * @property null|int     $EndMonth
 */
class Work extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Company' => 'RunetId\ApiClient\Model\Company\Company',
        ];
    }
}
