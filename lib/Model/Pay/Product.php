<?php

namespace RunetId\ApiClient\Model\Pay;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\PreDenormalizableInterface;
use RunetId\ApiClient\Model\ModelInterface;

class Product implements ModelInterface, ProductIdInterface, PreDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $manager;

    /**
     * @var null|float
     */
    protected $price;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $priceStart;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $priceEnd;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * {@inheritdoc}
     */
    public static function getRunetIdPreDenormalizationMap()
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
     * @return string
     */
    public function __toString()
    {
        return (string)$this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return null|float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getPriceStart()
    {
        return $this->priceStart;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getPriceEnd()
    {
        return $this->priceEnd;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
