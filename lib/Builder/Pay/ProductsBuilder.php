<?php

namespace RunetId\ApiClient\Builder\Pay;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setOnlyPublic(bool $onlyPublic)
 *
 * @method \RunetId\ApiClient\Result\Pay\ProductResult[] getResult()
 */
class ProductsBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Pay\ProductResult[]',
        'endpoint' => '/pay/products',
        'method' => 'GET',
    ];
}
