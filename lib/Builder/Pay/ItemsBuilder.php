<?php

namespace RunetId\ApiClient\Builder\Pay;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Common\UserRunetIdInterface;

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
        return $this->setParam('OwnerRunetId', ArgHelper::getUserRunetId($ownerRunetId));
    }
}
