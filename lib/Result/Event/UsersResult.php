<?php

namespace RunetId\ApiClient\Result\Event;

use Ruvents\AbstractApiClient\Result\AbstractResult;
use RunetId\ApiClient\Result\User\UserResult;

/**
 * @property UserResult[] $Users
 * @property int          $TotalCount
 */
class UsersResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Users' => 'RunetId\ApiClient\Result\User\UserResult[]',
        ];
    }
}
