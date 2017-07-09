<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\User\RunetIdInterface;
use RunetId\ApiClient\Model\User\UserInterface;

class UserFacade extends AbstractFacade
{
    /**
     * @param int|RunetIdInterface $runetId
     * @param array                $context
     *
     * @return array|UserInterface
     */
    public function get($runetId, array $context = [])
    {
        return $this->requestGet($context, '/user/get', ['RunetId' => $this->toRunetId($runetId)]);
    }

    /**
     * @param string $token
     * @param array  $context
     *
     * @return array|UserInterface
     */
    public function getByToken($token, array $context = [])
    {
        return $this->requestGet($context, '/user/auth', ['token' => $token]);
    }

    /**
     * @param array $data
     * @param array $context
     *
     * @return array|UserInterface
     */
    public function create(array $data, array $context = [])
    {
        return $this->requestPost($context, '/user/create', $data);
    }

    /**
     * @param array $data
     * @param array $context
     *
     * @return array|UserInterface
     */
    public function edit(array $data, array $context = [])
    {
        return $this->requestPost($context, '/user/edit', $data);
    }
}
