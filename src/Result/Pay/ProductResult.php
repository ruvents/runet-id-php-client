<?php

namespace RunetId\Client\Result\Pay;

use RunetId\Client\Result\AbstractResult;

/**
 * @property int         $Id
 * @property string      $Manager
 * @property null|string $Title
 * @property null|int    $Price
 * @property null|string $PriceStartTime
 * @property null|string $PriceEndTime
 * @property array       $Attributes
 */
final class ProductResult extends AbstractResult
{
}
