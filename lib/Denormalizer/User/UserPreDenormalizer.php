<?php

namespace RunetId\ApiClient\Denormalizer\User;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\User\User;

class UserPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'runetId' => 'RunetId',
            'firstName' => 'FirstName',
            'lastName' => 'LastName',
            'fatherName' => 'FatherName',
            'email' => 'Email',
            'phone' => 'Phone',
            'visible' => 'Visible',
            'gender' => function (array $raw, &$exists) {
                if ($exists = array_key_exists('Gender', $raw)) {
                    return 'none' === $raw['Gender'] ? null : $raw['Gender'];
                }

                return null;
            },
            'verified' => 'Verified',
            'createdAt' => 'CreationTime',
            'attributes' => 'Attributes',
            'work' => 'Work',
            'participation' => 'Status',
            'photo' => function (array $raw, &$exists) {
                if ($exists = isset($raw['Photo']['Original'])) {
                    return $raw['Photo']['Original'];
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
        return User::className();
    }
}
