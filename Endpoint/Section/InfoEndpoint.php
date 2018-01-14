<?php

namespace RunetId\Client\Endpoint\Section;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Program\SectionResult;

/**
 * @method $this         setSectionId(string $sectionId)
 * @method SectionResult getResult()
 */
final class InfoEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/section/info';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return SectionResult::class;
    }
}
