<?php

namespace RunetId\Client\Endpoint\Event;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Event\RoleResult;

/**
 * @method RoleResult[] getResult()
 */
final class RolesEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/event/roles';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return RoleResult::class.'[]';
    }
}
