<?php

namespace RunetId\ApiClient\Denormalizer\Event;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Event\Participation;

class ParticipationPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'ticketUrl' => 'TicketUrl',
            'registered' => 'Registered',
            'updatedAt' => 'UpdateTime',
            'status' => function (array $raw, &$exists) {
                if ($exists = isset($raw['RoleId']) && isset($raw['RoleName'])) {
                    return [
                        'RoleId' => $raw['RoleId'],
                        'Name' => $raw['RoleName'],
                    ];
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
        return Participation::className();
    }
}
