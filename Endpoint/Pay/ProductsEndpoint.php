<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\Pay\ProductResult;

/**
 * @method $this setOnlyPublic(bool $onlyPublic)
 * @method ProductResult[] getResult()
 */
final class ProductsEndpoint extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/products';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return ProductResult::class.'[]';
    }
}
