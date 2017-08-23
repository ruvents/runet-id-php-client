<?php

namespace RunetId\ApiClient\Denormalizer\Common;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Common\Address;

class AddressPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'country' => 'Country',
            'region' => 'Region',
            'city' => 'City',
            'postCode' => 'PostCode',
            'street' => 'Street',
            'house' => 'House',
            'building' => 'Building',
            'wing' => 'Wing',
            'apartment' => 'Apartment',
            'place' => 'Place',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return Address::className();
    }
}
