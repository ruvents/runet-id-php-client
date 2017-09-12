<?php

namespace RunetId\ApiClient\Builder\Pay;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Common\PayProductIdInterface;
use RunetId\ApiClient\Common\UserRunetIdInterface;

/**
 * @method $this setAttributes(array $attributes)
 *
 * @method \RunetId\ApiClient\Result\Pay\ItemResult getResult()
 */
class AddBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Pay\ItemResult',
        'endpoint' => '/pay/add',
        'method' => 'POST',
    ];

    /**
     * @param int|UserRunetIdInterface $payerRunetId
     *
     * @return $this
     */
    public function setPayerRunetId($payerRunetId)
    {
        return $this->setParam('PayerRunetId', ArgHelper::getUserRunetId($payerRunetId));
    }

    /**
     * @param int|UserRunetIdInterface $ownerRunetId
     *
     * @return $this
     */
    public function setOwnerRunetId($ownerRunetId)
    {
        return $this->setParam('OwnerRunetId', ArgHelper::getUserRunetId($ownerRunetId));
    }

    /**
     * @param int|PayProductIdInterface $productId
     *
     * @return $this
     */
    public function setProductId($productId)
    {
        return $this->setParam('ProductId', ArgHelper::getPayProductId($productId));
    }
}
