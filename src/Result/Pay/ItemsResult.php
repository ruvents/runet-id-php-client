<?php

namespace RunetId\ApiClient\Result\Pay;

use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property ItemResult[] $Items
 */
class ItemsResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Items' => 'RunetId\ApiClient\Result\Pay\ItemResult[]',
        ];
    }
}
