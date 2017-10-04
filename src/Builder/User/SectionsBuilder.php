<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Builder\SetRunetIdTrait;

/**
 * @method \RunetId\ApiClient\Result\User\SectionParticipationResult[] getResult()
 */
class SectionsBuilder extends AbstractBuilder
{
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\SectionParticipationResult[]',
        'endpoint' => '/user/sections',
        'method' => 'GET',
    ];
}
