<?php

namespace RunetId\ApiClient\Denormalizer\Common;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Common\GeoPoint;

class GeoPointPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'latitude' => 0,
            'longitude' => 1,
            'scale' => 2,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return GeoPoint::className();
    }
}
