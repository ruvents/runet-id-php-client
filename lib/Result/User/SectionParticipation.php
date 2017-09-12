<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\Result\AbstractResult;
use RunetId\ApiClient\Result\Program\Section;

/**
 * @property Section     $Section
 * @property null|string $Role
 * @property null|string $VideoUrl
 */
class SectionParticipation extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Section' => 'RunetId\ApiClient\Result\Program\Section',
            //'Report' => 'RunetId\ApiClient\Result\Program\Report',
        ];
    }
}
