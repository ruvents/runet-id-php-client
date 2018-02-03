<?php

namespace RunetId\Client\Endpoint\Event;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

/**
 * @method $this setRoleId(int $roleId)
 * @method $this setRunetId(int $runetId)
 */
final class ChangeRoleEndpoint extends AbstractPostEndpoint
{
    use SuccessResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/event/changerole';
    }
}
