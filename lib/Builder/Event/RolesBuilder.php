<?php

namespace RunetId\ApiClient\Builder\Event;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;

/**
 * @method \RunetId\ApiClient\Result\Event\Role[] getResult()
 */
class RolesBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Event\Role[]',
        'endpoint' => '/event/roles',
        'method' => 'GET',
    ];
}
