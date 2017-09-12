<?php

namespace RunetId\ApiClient\Result\Pay;

use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property ItemResult[]  $Items
 * @property OrderResult[] $Orders
 */
class ListResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'Items' => 'RunetId\ApiClient\Result\Pay\ItemResult[]',
            'Orders' => 'RunetId\ApiClient\Result\Pay\OrderResult[]',
        ];
    }
}
