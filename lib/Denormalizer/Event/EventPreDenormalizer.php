<?php

namespace RunetId\ApiClient\Denormalizer\Event;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Event\Event;

class EventPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'id' => 'EventId',
            'alias' => 'IdName',
            'title' => 'Title',
            'info' => 'Info',
            'fullInfo' => 'FullInfo',
            'place' => 'Place',
            'url' => 'Url',
            'registrationUrl' => 'UrlRegistration',
            'programUrl' => 'UrlProgram',
            'address' => 'Address',
            'geoPoint' => function (array $raw, &$exists) {
                if ($exists = isset($raw['GeoPoint'])) {
                    return '' !== ($raw['GeoPoint'][0]) && '' !== ($raw['GeoPoint'][1]) && '' !== ($raw['GeoPoint'][2])
                        ? $raw['GeoPoint']
                        : null;
                }

                return null;
            },
            'start' => function (array $raw, &$exists) {
                if ($exists = isset($raw['StartYear']) && isset($raw['StartMonth']) && isset($raw['StartDay'])) {
                    return $raw['StartYear'].'-'.$raw['StartMonth'].'-'.$raw['StartDay'];
                }

                return null;
            },
            'end' => function (array $raw, &$exists) {
                if ($exists = isset($raw['EndYear']) && isset($raw['EndMonth']) && isset($raw['EndDay'])) {
                    return $raw['EndYear'].'-'.$raw['EndMonth'].'-'.$raw['EndDay'];
                }

                return null;
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return Event::className();
    }
}
