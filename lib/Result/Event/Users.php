<?php

namespace RunetId\ApiClient\Result\Event;

use RunetId\ApiClient\Result\AbstractResult;
use RunetId\ApiClient\Result\User\User;

/**
 * @property User[] $Users
 * @property int    $TotalCount
 */
class Users extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Users' => 'RunetId\ApiClient\Result\User\User[]',
        ];
    }
}
