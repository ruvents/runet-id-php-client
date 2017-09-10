<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\ObjectResultTrait;
use RunetId\ApiClient\Builder\SetRunetIdTrait;
use RunetId\ApiClient\Result\User\Professionalinterest;

/**
 * @method Professionalinterest[] getResult()
 */
class ProfessionalinterestsBuilder extends AbstractEndpointBuilder
{
    use SetRunetIdTrait;
    use ObjectResultTrait;

    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/professionalinterests',
        'method' => 'GET',
    ];

    /**
     * @return string
     */
    protected function getResultClass()
    {
        return Professionalinterest::className().'[]';
    }
}
