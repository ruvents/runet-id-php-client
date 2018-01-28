<?php

namespace RunetId\Client\Result\Event;

use RunetId\Client\Result\AbstractResult;

/**
 * @property int                      $EventId
 * @property string                   $Alias
 * @property string                   $Title
 * @property string                   $Info
 * @property string                   $FullInfo
 * @property string                   $Url
 * @property int                      $StartYear
 * @property int                      $StartMonth
 * @property int                      $StartDay
 * @property int                      $EndYear
 * @property int                      $EndMonth
 * @property int                      $EndDay
 * @property bool                     $VisibleOnMain
 * @property null|string              $Place
 * @property null|PlaceGeoPointResult $PlaceGeoPoint
 * @property null|AddressResult       $Address
 * @property null|string              $FbPlaceId
 * @property null|ImageResult         $Image
 * @property null|string              $Photo
 * @property array                    $Statistics
 */
final class InfoResult extends AbstractResult
{
    /**
     * {@inheritdoc}
     */
    public static function getMap()
    {
        return [
            'PlaceGeoPoint' => PlaceGeoPointResult::class,
            'Address' => AddressResult::class,
            'Image' => ImageResult::class,
        ];
    }
}
