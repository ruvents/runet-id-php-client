<?php

namespace RunetId\ApiClient\Model\Pay;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\ModelInterface;

class ItemList implements ModelInterface, \IteratorAggregate
{
    use ClassTrait;

    /**
     * @var Order[]
     */
    protected $orders = [];

    /**
     * @var Item[]
     */
    protected $nonOrderedItems = [];

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return \AppendIterator|Item[]
     */
    public function getOrderedItemsIterator()
    {
        $iterator = new \AppendIterator();

        foreach ($this->orders as $order) {
            $iterator->append(new \IteratorIterator($order));
        }

        return $iterator;
    }

    /**
     * @return Item[]
     */
    public function getNonOrderedItems()
    {
        return $this->nonOrderedItems;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Traversable|Item[]
     */
    public function getIterator()
    {
        $iterator = new \AppendIterator();

        $iterator->append($this->getOrderedItemsIterator());
        $iterator->append(new \ArrayIterator($this->nonOrderedItems));

        return $iterator;
    }
}
