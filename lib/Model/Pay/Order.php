<?php

namespace RunetId\ApiClient\Model\Pay;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\ModelInterface;

class Order implements ModelInterface, OrderIdInterface, \IteratorAggregate
{
    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var null|string
     */
    protected $number;

    /**
     * @var null|bool
     */
    protected $paid;

    /**
     * @var null|string
     */
    protected $url;

    /**
     * @var Item[]
     */
    protected $items;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return null|string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return null|bool
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Traversable|Item[]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}
