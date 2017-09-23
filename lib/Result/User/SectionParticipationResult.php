<?php

namespace RunetId\ApiClient\Result\User;

use Ruvents\AbstractApiClient\Result\AbstractResult;
use RunetId\ApiClient\Result\Program\SectionResult;

/**
 * @property SectionResult $Section
 * @property null|string   $Role
 * @property null|string   $VideoUrl
 */
class SectionParticipationResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Section' => 'RunetId\ApiClient\Result\Program\SectionResult',
            //'Report' => 'RunetId\ApiClient\Result\Program\ReportResult',
        ];
    }
}
