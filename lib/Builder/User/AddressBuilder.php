<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\ObjectResultTrait;
use RunetId\ApiClient\Builder\SetRunetIdTrait;
use RunetId\ApiClient\Result\User\Address;

/**
 * @method Address getResult()
 */
class AddressBuilder extends AbstractEndpointBuilder
{
    use ObjectResultTrait;
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/address',
        'method' => 'GET',
    ];

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return Address::className();
    }
}
