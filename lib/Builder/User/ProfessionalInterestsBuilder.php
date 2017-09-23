<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Builder\SetRunetIdTrait;

/**
 * @method \RunetId\ApiClient\Result\User\ProfessionalInterestResult[] getResult()
 */
class ProfessionalInterestsBuilder extends AbstractBuilder
{
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\ProfessionalinterestResult[]',
        'endpoint' => '/user/professionalinterests',
        'method' => 'GET',
    ];
}
