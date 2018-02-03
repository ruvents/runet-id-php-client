<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

/**
 * @method $this setEmail(string $email)
 * @method $this setPassword(string $password)
 * @method $this setDeviceType(string $deviceType)   iOS|Android
 * @method $this setDeviceToken(string $deviceToken)
 */
final class PasswordChangeEndpoint extends AbstractPostEndpoint
{
    use SuccessResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/passwordChange';
    }
}
