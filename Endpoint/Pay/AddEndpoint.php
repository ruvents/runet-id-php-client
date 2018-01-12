<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Result\Pay\ItemResult;

/**
 * @method $this setAttributes(array $attributes)
 * @method $this setOwnerRunetId(array $ownerRunetId)
 * @method $this setPayerRunetId(int $payerRunetId)
 * @method $this setProductId(int $productId)
 * @method ItemResult getResult()
 */
final class AddEndpoint extends AbstractPostEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/add';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ItemResult::class;
    }
}
