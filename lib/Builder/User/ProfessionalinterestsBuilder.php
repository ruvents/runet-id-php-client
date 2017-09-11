<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\SetRunetIdTrait;

/**
 * @method \RunetId\ApiClient\Result\User\Professionalinterest[] getResult()
 */
class ProfessionalinterestsBuilder extends AbstractEndpointBuilder
{
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\Professionalinterest[]',
        'endpoint' => '/user/professionalinterests',
        'method' => 'GET',
    ];
}
