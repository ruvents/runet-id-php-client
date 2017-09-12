<?php

namespace RunetId\ApiClient\Builder\Pay;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Common\UserRunetIdInterface;

/**
 * @method \RunetId\ApiClient\Result\Pay\ListResult getResult()
 */
class ListBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Pay\ListResult',
        'endpoint' => '/pay/list',
        'method' => 'GET',
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
}
