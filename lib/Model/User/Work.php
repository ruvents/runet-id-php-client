<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Model\AbstractModel;
use RunetId\ApiClient\Model\Company\Company;

/**
 * @property null|string  $Position
 * @property null|Company $Company
 * @property null|int     $StartYear
 * @property null|int     $StartMonth
 * @property null|int     $EndYear
 * @property null|int     $EndMonth
 */
class Work extends AbstractModel
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
