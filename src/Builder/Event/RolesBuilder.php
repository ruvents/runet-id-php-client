<?php

namespace RunetId\ApiClient\Builder\Event;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method \RunetId\ApiClient\Result\Event\RoleResult[] getResult()
 */
class RolesBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Event\RoleResult[]',
        'endpoint' => '/event/roles',
        'method' => 'GET',
    ];
}
