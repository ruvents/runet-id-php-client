<?php

namespace RunetId\Client\Result\Program;

use RunetId\Client\Result\AbstractResult;

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
final class SectionResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Halls' => HallResult::class.'[]',
        ];
    }
}
