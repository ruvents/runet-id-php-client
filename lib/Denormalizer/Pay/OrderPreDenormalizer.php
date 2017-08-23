<?php

namespace RunetId\ApiClient\Denormalizer\Pay;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Pay\Order;

class OrderPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'id' => 'OrderId',
            'createdAt' => 'CreationTime',
            'number' => 'Number',
            'paid' => 'Paid',
            'url' => 'Url',
            'items' => 'Items',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return Order::className();
    }
}
