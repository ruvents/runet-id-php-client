<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\User\SectionParticipationResult;

/**
 * @method $this setRunetId(int $runetId)
 * @method SectionParticipationResult[] getResult()
 */
final class SectionsEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/sections';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return SectionParticipationResult::class.'[]';
    }
}
