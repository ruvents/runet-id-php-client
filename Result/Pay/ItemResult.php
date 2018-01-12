<?php

namespace RunetId\Client\Result\Pay;

use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\User\UserResult;

/**
 * @property int           $Id
 * @property ProductResult $Product
 * @property UserResult    $Payer
 * @property UserResult    $Owner
 * @property int           $PriceDiscount
 * @property bool          $Paid
 * @property null|string   $PaidTime
 * @property null|bool     $Booked
 * @property bool          $Deleted
 * @property string        $CreationTime
 * @property array         $Attributes
 * @property int           $Discount
 * @property null|string   $CouponCode
 * @property bool          $GroupDiscount
 */
final class ItemResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'Product' => ProductResult::class,
            'Payer' => UserResult::class,
            'Owner' => UserResult::class,
        ];
    }
}
