<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\SuccessResultTrait;

/**
 * @method $this setCredential(string $credential) Email|Phone|RunetId
 *
 * @method bool getResult()
 */
class PasswordRestoreBuilder extends AbstractEndpointBuilder
{
    use SuccessResultTrait;

    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/login',
        'method' => 'POST',
    ];
}
