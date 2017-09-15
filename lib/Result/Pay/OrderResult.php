<?php

namespace RunetId\ApiClient\Result\Pay;

use RunetId\ApiClient\ArgumentHelper\PayOrderIdInterface;
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
    public function __construct(array $result)
    {
        $result['Items'] = array_map(function (array $result) {
            return new ItemResult($result, $this);
        }, $result['Items']);

        parent::__construct($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->OrderId;
    }
}
