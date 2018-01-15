<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Event\UsersResult;

/**
 * @method UsersResult getResult()
 */
final class SearchEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/event/users';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return UsersResult::class;
    }
}
