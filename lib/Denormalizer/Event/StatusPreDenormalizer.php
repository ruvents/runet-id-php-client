<?php

namespace RunetId\ApiClient\Denormalizer\Event;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Event\Status;

class StatusPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'id' => 'RoleId',
            'title' => 'Name',
            'priority' => 'Priority',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return Status::className();
    }
}
