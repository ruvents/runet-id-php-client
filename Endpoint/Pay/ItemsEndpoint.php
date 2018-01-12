<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Pay\ItemsResult;

/**
 * @method $this setOwnerRunetId(array $ownerRunetId)
 * @method ItemsResult getResult()
 */
final class ItemsEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/items';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ItemsResult::class;
    }
}
