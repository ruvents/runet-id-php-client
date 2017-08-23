<?php

namespace RunetId\ApiClient\Model\Pay;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\PreDenormalizableInterface;
use RunetId\ApiClient\Model\ModelInterface;
use RunetId\ApiClient\Model\User\User;

class Item implements ModelInterface, ItemIdInterface, PreDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|Product
     */
    protected $product;

    /**
     * @var null|User
     */
    protected $payer;

    /**
     * @var null|User
     */
    protected $owner;

    /**
     * @var null|float
     */
    protected $cost;

    /**
     * @var null|bool
     */
    protected $paid;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $paidAt;

    /**
     * @var null|bool
     */
    protected $booked;

    /**
     * @var null|bool
     */
    protected $deleted;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var null|array
     */
    protected $attributes;

    /**
     * @var null|float
     */
    protected $discount;

    /**
     * @var null|string
     */
    protected $activatedPromoCode;

    /**
     * @var null|Order
     */
    protected $order;

    public function __construct(Order $order = null)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return null|User
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @return null|User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return null|float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return null|bool
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getPaidAt()
    {
        return $this->paidAt;
    }

    /**
     * @return null|bool
     */
    public function isBooked()
    {
        return $this->booked;
    }

    /**
     * @return null|bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return null|array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return null|float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return null|string
     */
    public function getActivatedPromoCode()
    {
        return $this->activatedPromoCode;
    }

    /**
     * @return null|Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return bool
     */
    public function isFree()
    {
        return 0 == $this->cost;
    }

    /**
     * {@inheritdoc}
     */
    public static function getRunetIdPreDenormalizationMap()
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
}
