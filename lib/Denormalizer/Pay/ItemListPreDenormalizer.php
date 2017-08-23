<?php

namespace RunetId\ApiClient\Denormalizer\Pay;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Pay\ItemList;

class ItemListPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'orders' => 'Orders',
            'nonOrderedItems' => function (array $raw) {
                $itemsById = array_combine(array_map(function (array $item) {
                    return (int)$item['Id'];
                }, $raw['Items']), $raw['Items']);

                foreach ($raw['Orders'] as $order) {
                    foreach ($order['Items'] as $item) {
                        if (isset($itemsById[$id = (int)$item['Id']])) {
                            unset($itemsById[$id]);
                        }
                    }
                }

                return array_values($itemsById);
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return ItemList::className();
    }
}
