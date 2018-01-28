<?php

namespace RunetId\Client\Endpoint\Event;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Event\InfoResult;

/**
 * @method InfoResult getResult()
 */
final class InfoEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/event/info';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return InfoResult::class;
    }
}
