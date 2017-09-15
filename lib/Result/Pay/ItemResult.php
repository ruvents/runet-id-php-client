<?php

namespace RunetId\ApiClient\Result\Pay;

use RunetId\ApiClient\ArgumentHelper\PayItemIdInterface;
use RunetId\ApiClient\Result\AbstractResult;
use RunetId\ApiClient\Result\User\UserResult;

/**
 * @property int           $Id
 * @property ProductResult $Product
 * @property UserResult    $Payer
 * @property UserResult    $Owner
 * @property int           $PriceDiscount
 * @property bool          $Paid
 * @property null|string   $PaidTime
 * @property null|bool     $Booked
 * @property bool          $Deleted
 * @property string        $CreationTime
 * @property array         $Attributes
 * @property int           $Discount
 * @property null|string   $CouponCode
 * @property bool          $GroupDiscount
 */
class ItemResult extends AbstractResult implements PayItemIdInterface
{
    /**
     * @var null|OrderResult
     */
    private $order;

    /**
     * @param array            $result
     * @param null|OrderResult $order
     */
    public function __construct(array $result, OrderResult $order = null)
    {
        parent::__construct($result);
        $this->order = $order;
    }

    /**
     * {@inheritdoc}
     */
    public function getMap()
    {
        return [
            'Product' => 'RunetId\ApiClient\Result\Pay\ProductResult',
            'Payer' => 'RunetId\ApiClient\Result\User\UserResult',
            'Owner' => 'RunetId\ApiClient\Result\User\UserResult',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @return null|OrderResult
     */
    public function getOrder()
    {
        return $this->order;
    }
}
