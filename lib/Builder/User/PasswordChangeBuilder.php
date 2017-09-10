<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;
use RunetId\ApiClient\Builder\SuccessResultTrait;
use RunetId\ApiClient\Result\Success;

/**
 * @method $this setEmail(string $email)
 * @method $this setPassword(string $password)
 * @method $this setDeviceType(string $deviceType) iOS|Android
 * @method $this setDeviceToken(string $deviceToken)
 *
 * @method Success getResult()
 */
class PasswordChangeBuilder extends AbstractEndpointBuilder
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
