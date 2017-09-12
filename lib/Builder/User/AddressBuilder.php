<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;
use RunetId\ApiClient\Builder\SetRunetIdTrait;

/**
 * @method \RunetId\ApiClient\Result\User\AddressResult getResult()
 */
class AddressBuilder extends AbstractBuilder
{
    use SetRunetIdTrait;

    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\AddressResult',
        'endpoint' => '/user/address',
        'method' => 'GET',
    ];
}
