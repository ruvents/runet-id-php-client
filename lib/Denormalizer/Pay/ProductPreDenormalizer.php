<?php

namespace RunetId\ApiClient\Denormalizer\Pay;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Pay\Product;

class ProductPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'id' => 'Id',
            'title' => 'Title',
            'manager' => 'Manager',
            'price' => 'Price',
            'priceStart' => 'PriceStartTime',
            'priceEnd' => 'PriceEndTime',
            'attributes' => 'Attributes',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return Product::className();
    }
}
