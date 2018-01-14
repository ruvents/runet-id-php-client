<?php

namespace RunetId\Client\Endpoint\Section;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Program\SectionResult;

/**
 * @method $this           setFromUpdateTime(string $fromUpdateTime)
 * @method SectionResult[] getResult()
 */
final class ListEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/section/list';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return SectionResult::class.'[]';
    }
}
