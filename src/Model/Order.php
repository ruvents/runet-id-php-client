<?php

namespace RunetId\ApiClient\Model;

/**
 * Class Order
 */
class Order
{
    /**
     * @var int
     */
    public $OrderId;

    /**
     * @var \DateTime
     */
    public $CreationTime;

    /**
     * @var string
     */
    public $Number;

    /**
     * @var bool
     */
    public $Paid;

    /**
     * @var string
     */
    public $Url;

    /**
     * @var OrderItem[]
     */
    public $Items;
}
