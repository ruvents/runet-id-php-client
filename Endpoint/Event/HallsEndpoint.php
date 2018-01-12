<?php

namespace RunetId\Client\Endpoint\Event;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Program\HallResult;

/**
 * @method $this        setFromUpdateTime(string $fromUpdateTime)
 * @method $this        setWithDeleted(bool $withDeleted)
 * @method HallResult[] getResult()
 */
final class HallsEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/event/halls';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return HallResult::class.'[]';
    }
}
