<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\SetRunetIdTrait;

/**
 * @method \RunetId\ApiClient\Result\User\SectionParticipation[] getResult()
 */
class SectionsBuilder extends AbstractEndpointBuilder
{
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\SectionParticipation[]',
        'endpoint' => '/user/sections',
        'method' => 'GET',
    ];
}
