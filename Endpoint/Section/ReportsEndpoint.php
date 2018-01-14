<?php

namespace RunetId\Client\Endpoint\Section;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Program\ReportResult;

/**
 * @method $this          setSectionId(string $sectionId)
 * @method $this          setFromUpdateTime(string $fromUpdateTime)
 * @method ReportResult[] getResult()
 */
final class ReportsEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/section/reports';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ReportResult::class.'[]';
    }
}
