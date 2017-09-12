<?php

namespace RunetId\ApiClient\Result\Pay;

use RunetId\ApiClient\Common\PayOrderIdInterface;
use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property int          $OrderId
 * @property string       $CreationTime
 * @property string       $Number
 * @property bool         $Paid
 * @property string       $Url
 * @property ItemResult[] $Items
 */
class OrderResult extends AbstractResult implements PayOrderIdInterface
{
    /**
     * {@inheritdoc}
     */
    public function getMap()
    {
        return [
            'Items' => 'RunetId\ApiClient\Result\Pay\ItemResult[]',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->OrderId;
    }
}
