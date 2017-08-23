<?php

namespace RunetId\ApiClient\Denormalizer\User;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\User\Work;

class WorkPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'position' => 'Position',
            'company' => 'Company',
            'start' => function (array $raw, &$exists) {
                if ($exists = isset($raw['StartYear'])) {
                    return $raw['StartYear'].'-'.(isset($raw['StartMonth']) ? $raw['StartMonth'] : 1);
                }

                return null;
            },
            'end' => function (array $raw, &$exists) {
                if ($exists = isset($raw['StartYear']) && isset($raw['EndYear'])) {
                    return $raw['EndYear'].'-'.(isset($raw['EndMonth']) ? $raw['EndMonth'] : 1);
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
        return Work::className();
    }
}
