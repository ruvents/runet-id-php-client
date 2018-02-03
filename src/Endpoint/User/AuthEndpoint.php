<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\User\UserResult;

/**
 * @method UserResult getResult()
 */
final class AuthEndpoint extends AbstractEndpoint
{
    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        return $this->setQueryValue('token', $token);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/auth';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return UserResult::class;
    }
}
