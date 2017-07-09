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
        return $this->requestGet('/user/get', ['RunetId' => $this->toRunetId($runetId)], $context);
    }

    /**
     * @param string $token
     * @param array  $context
     *
     * @return array|UserInterface
     */
    public function getByToken($token, array $context = [])
    {
        return $this->requestGet('/user/auth', ['token' => $token], $context);
    }

    /**
     * @param array $data
     * @param array $context
     *
     * @return array|UserInterface
     */
    public function create(array $data, array $context = [])
    {
        return $this->requestPost('/user/create', $data, $context);
    }

    /**
     * @param array $data
     * @param array $context
     *
     * @return array|UserInterface
     */
    public function edit(array $data, array $context = [])
    {
        return $this->requestPost('/user/edit', $data, $context);
    }
}
