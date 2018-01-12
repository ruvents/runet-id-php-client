<?php

namespace RunetId\Client\Result\Pay;

use RunetId\Client\Result\AbstractResult;

/**
 * @property ItemResult[] $Items
 */
final class ItemsResult extends AbstractResult
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
