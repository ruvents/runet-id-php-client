<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setEmail(string $email)
 * @method $this setPassword(string $password)
 * @method $this setDeviceType(string $deviceType) iOS|Android
 * @method $this setDeviceToken(string $deviceToken)
 *
 * @method \RunetId\ApiClient\Result\User\UserResult getResult()
 */
class LoginBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\UserResult',
        'endpoint' => '/user/login',
        'method' => 'POST',
    ];
}
