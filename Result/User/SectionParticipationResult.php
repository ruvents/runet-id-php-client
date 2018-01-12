<?php

namespace RunetId\Client\Result\User;

use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\Program\SectionResult;

/**
 * @property SectionResult $Section
 * @property null|string   $Role
 * @property null|string   $VideoUrl
 */
final class SectionParticipationResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Section' => SectionResult::class,
            //'Report' => 'RunetId\Client\Result\Program\ReportResult',
        ];
    }
}
