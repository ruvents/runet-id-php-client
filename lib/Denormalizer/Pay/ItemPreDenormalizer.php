<?php

namespace RunetId\ApiClient\Denormalizer\Pay;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Pay\Item;

class ItemPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'id' => 'Id',
            'product' => 'Product',
            'payer' => 'Payer',
            'owner' => 'Owner',
            'cost' => 'PriceDiscount',
            'paid' => 'Paid',
            'paidAt' => 'PaidTime',
            'booked' => function (array $raw) {
                return isset($raw['Booked']) ? $raw['Booked'] : false;
            },
            'deleted' => 'Deleted',
            'createdAt' => 'CreationTime',
            'attributes' => 'Attributes',
            'discount' => 'Discount',
            'activatedPromoCode' => 'ActivatedPromoCode',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return Item::className();
    }
}
