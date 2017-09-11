<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;

/**
 * @method $this setCredential(string $credential) Email|Phone|RunetId
 *
 * @method \RunetId\ApiClient\Result\Success getResult()
 */
class PasswordRestoreBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\Success',
        'endpoint' => '/user/login',
        'method' => 'POST',
    ];
}
