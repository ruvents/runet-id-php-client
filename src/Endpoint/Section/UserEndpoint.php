<?php

namespace RunetId\Client\Endpoint\Section;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Program\SectionResult;

/**
 * @method $this           setRunetId(int $runetId)
 * @method SectionResult[] getResult()
 */
final class UserEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/section/user';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return SectionResult::class.'[]';
    }
}
