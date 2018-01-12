<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

/**
 * @method $this setAttributes(array $attributes)
 * @method $this setOwnerRunetId(array $ownerRunetId)
 * @method $this setPayerRunetId(int $payerRunetId)
 * @method $this setProductId(int $productId)
 */
final class EditEndpoint extends AbstractPostEndpoint
{
    use SuccessResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/edit';
    }
}
