<?php

namespace RunetId\Client\Result\Competence;

use RunetId\Client\Result\AbstractResult;

/**
 * @property int              $Id
 * @property string           $Title
 * @property QuestionResult[] $Questions
 */
final class TestResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Questions' => QuestionResult::class.'[]',
        ];
    }
}
