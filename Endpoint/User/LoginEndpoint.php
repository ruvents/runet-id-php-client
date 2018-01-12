<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Result\User\UserResult;

/**
 * @method $this setEmail(string $email)
 * @method $this setPassword(string $password)
 * @method $this setDeviceType(string $deviceType) iOS|Android
 * @method $this setDeviceToken(string $deviceToken)
 * @method UserResult getResult()
 */
final class LoginEndpoint extends AbstractPostEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/login';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return UserResult::class;
    }
}
