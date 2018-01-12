<?php

namespace RunetId\Client\Result\Pay;

use RunetId\Client\Result\AbstractResult;

/**
 * @property ItemResult[]  $Items
 * @property OrderResult[] $Orders
 */
final class ListResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Items' => ItemResult::class.'[]',
            'Orders' => OrderResult::class.'[]',
        ];
    }
}
