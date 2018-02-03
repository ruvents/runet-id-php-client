<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Endpoint\PaginatedEndpointTrait;
use RunetId\Client\Result\Event\UsersResult;

/**
 * @method $this       setQuery(string $query)
 * @method $this       setEventId(int $eventId)
 * @method $this       setVisible(bool $visible)
 * @method UsersResult getResult()
 */
final class SearchEndpoint extends AbstractEndpoint
{
    use PaginatedEndpointTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/search';
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
