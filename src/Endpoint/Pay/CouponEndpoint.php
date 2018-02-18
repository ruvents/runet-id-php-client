<?php

namespace RunetId\Client\Endpoint\Pay;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Result\Pay\CouponResult;

/**
 * @method $this        setCouponCode(string $couponCode)
 * @method $this        setOwnerRunetId(int $ownerRunetId)
 * @method $this        setPayerRunetId(int $payerRunetId)
 * @method $this        setProductId(int $productId)
 * @method CouponResult getResult()
 */
final class CouponEndpoint extends AbstractPostEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/pay/coupon';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return CouponResult::class;
    }
}
