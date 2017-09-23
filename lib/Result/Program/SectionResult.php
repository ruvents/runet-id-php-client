<?php

namespace RunetId\ApiClient\Result\Program;

use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property int          $Id
 * @property null|string  $Title
 * @property null|string  $ShortTitle
 * @property null|string  $Info
 * @property null|string  $Start
 * @property null|string  $End
 * @property null|string  $UpdateTime
 * @property null|bool    $Deleted
 * @property null|string  $TypeCode
 * @property HallResult[] $Halls
 * @property string[]     $Places
 * @property array        $Attributes
 * @property int[]        $Speakers
 */
class SectionResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Halls' => 'RunetId\ApiClient\Result\Program\HallResult[]',
        ];
    }
}
