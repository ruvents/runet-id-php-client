<?php

namespace RunetId\ApiClient\Builder\Pay;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\ArgumentHelper\ArgumentHelper;
use RunetId\ApiClient\ArgumentHelper\PayProductIdInterface;
use RunetId\ApiClient\ArgumentHelper\UserRunetIdInterface;

/**
 * @method $this setCouponCode(string $couponCode)
 *
 * @method \RunetId\ApiClient\Result\Pay\CouponResult getResult()
 */
class CouponBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Pay\CouponResult',
        'endpoint' => '/pay/coupon',
        'method' => 'POST',
    ];

    /**
     * @param int|UserRunetIdInterface $payerRunetId
     *
     * @return $this
     */
    public function setPayerRunetId($payerRunetId)
    {
        return $this->setParam('PayerRunetId', ArgumentHelper::getUserRunetId($payerRunetId));
    }

    /**
     * @param int|UserRunetIdInterface $ownerRunetId
     *
     * @return $this
     */
    public function setOwnerRunetId($ownerRunetId)
    {
        return $this->setParam('OwnerRunetId', ArgumentHelper::getUserRunetId($ownerRunetId));
    }

    /**
     * @param int|PayProductIdInterface $productId
     *
     * @return $this
     */
    public function setProductId($productId)
    {
        return $this->setParam('ProductId', ArgumentHelper::getPayProductId($productId));
    }
}
