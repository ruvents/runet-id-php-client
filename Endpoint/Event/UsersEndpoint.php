<?php

namespace RunetId\Client\Endpoint\Event;

use RunetId\Client\Endpoint\AbstractPaginatedEndpoint;
use RunetId\Client\Result\Event\UsersResult;

/**
 * @method UsersResult getResult()
 */
final class UsersEndpoint extends AbstractPaginatedEndpoint
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

    /**
     * {@inheritdoc}
     */
    protected function getItemsKey()
    {
        return 'Users';
    }
}
