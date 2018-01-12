<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Result\User\UserResult;

/**
 * @method $this setEmail(string $email)
 * @method $this setRunetId(int $runetId)
 * @method UserResult getResult()
 */
final class GetEndpoint extends AbstractEndpoint
{
    /**
     * @param string|string[] $builders
     *
     * @return $this
     */
    public function setBuilders($builders)
    {
        if (is_array($builders)) {
            $builders = implode(',', $builders);
        }

        return $this->setQueryValue('Builders', $builders);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/get';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return UserResult::class;
    }
}
