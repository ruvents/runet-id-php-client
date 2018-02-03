<?php

namespace RunetId\Client\Result\Pay;

use RunetId\Client\Result\AbstractResult;

/**
 * @property int          $OrderId
 * @property string       $CreationTime
 * @property string       $Number
 * @property bool         $Paid
 * @property string       $Url
 * @property ItemResult[] $Items
 */
final class OrderResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Items' => ItemResult::class.'[]',
        ];
    }
}
