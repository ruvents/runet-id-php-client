<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractDeleteEndpoint;

/**
 * @method $this setOrderItemId(int $orderItemId)
 * @method $this setPayerRunetId(int $payerRunetId)
 */
final class DeleteEndpoint extends AbstractDeleteEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/delete';
    }
}
