<?php

namespace RunetId\ApiClient\Model;

/**
 * Class OrderItem
 */
class OrderItem
{
    /**
     * @var int
     */
    public $Id;

    /**
     * @var Product
     */
    public $Product;

    /**
     * @var User
     */
    public $Payer;

    /**
     * @var User
     */
    public $Owner;

    /**
     * @var int
     */
    public $PriceDiscount;

    /**
     * @var bool
     */
    public $Paid;

    /**
     * @var \DateTime
     */
    public $PaidTime;

    /**
     * @var bool
     */
    public $Booked;

    /**
     * @var bool
     */
    public $Deleted;

    /**
     * @var \DateTime
     */
    public $CreationTime;

    /**
     * @var array
     */
    public $Attributes;

    /**
     * @var int
     */
    public $Discount;

    /**
     * @var string
     */
    public $CouponCode;

    /**
     * @var bool
     */
    public $GroupDiscount;
}
