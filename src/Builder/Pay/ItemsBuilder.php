<?php

namespace RunetId\ApiClient\Builder\Pay;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\ArgumentHelper\ArgumentHelper;
use RunetId\ApiClient\ArgumentHelper\UserRunetIdInterface;

/**
 * @method \RunetId\ApiClient\Result\Pay\ItemsResult getResult()
 */
class ItemsBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Pay\ItemsResult',
        'endpoint' => '/pay/items',
        'method' => 'GET',
    ];

    /**
     * @param int|UserRunetIdInterface $ownerRunetId
     *
     * @return $this
     */
    public function setOwnerRunetId($ownerRunetId)
    {
        return $this->setParam('OwnerRunetId', ArgumentHelper::getUserRunetId($ownerRunetId));
    }
}
