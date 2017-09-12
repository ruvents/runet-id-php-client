<?php

namespace RunetId\ApiClient\Builder\Pay;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Common\PayItemIdInterface;
use RunetId\ApiClient\Common\UserRunetIdInterface;

/**
 * @method \RunetId\ApiClient\Result\SuccessResult getResult()
 */
class DeleteBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\SuccessResult',
        'endpoint' => '/pay/delete',
        'method' => 'POST',
    ];

    /**
     * @param int|PayItemIdInterface $orderItemId
     *
     * @return $this
     */
    public function setOrderItemId($orderItemId)
    {
        $this->context['data']['OrderItemId'] = ArgHelper::getPayItemId($orderItemId);

        return $this;
    }

    /**
     * @param int|UserRunetIdInterface $payerRunetId
     *
     * @return $this
     */
    public function setPayerRunetId($payerRunetId)
    {
        return $this->setParam('PayerRunetId', ArgHelper::getUserRunetId($payerRunetId));
    }
}
