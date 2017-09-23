<?php

namespace RunetId\ApiClient\Result\Pay;

use RunetId\ApiClient\ArgumentHelper\PayProductIdInterface;
use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property int         $Id
 * @property string      $Manager
 * @property null|string $Title
 * @property null|int    $Price
 * @property null|string $PriceStartTime
 * @property null|string $PriceEndTime
 * @property array       $Attributes
 */
class ProductResult extends AbstractResult implements PayProductIdInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->Id;
    }
}
