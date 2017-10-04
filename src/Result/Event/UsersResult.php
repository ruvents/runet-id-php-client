<?php

namespace RunetId\ApiClient\Result\Event;

use RunetId\ApiClient\Result\User\UserResult;
use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property UserResult[] $Users
 * @property int          $TotalCount
 * @property null|string  $NextPageToken
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
