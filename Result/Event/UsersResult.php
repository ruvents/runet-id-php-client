<?php

namespace RunetId\Client\Result\Event;

use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\User\UserResult;

/**
 * @property \Generator|UserResult[] $Users
 * @property int                     $TotalCount
 * @property null|string             $NextUpdateTime
 * @property null|string             $NextPageToken
 */
final class UsersResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Users' => UserResult::class.'[]',
        ];
    }
}
