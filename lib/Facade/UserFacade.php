<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Common\Address;
use RunetId\ApiClient\Model\User\ExternalIdInterface;
use RunetId\ApiClient\Model\User\RunetIdInterface;
use RunetId\ApiClient\Model\User\User;

class UserFacade extends AbstractFacade
{
    /**
     * @param int|RunetIdInterface $runetId
     * @param array                $context
     *
     * @return array|User
     */
    public function get($runetId, array $context = [])
    {
        return $this->requestGet($context, '/user/get', ['RunetId' => $this->toRunetId($runetId)]);
    }

    /**
     * @param string|ExternalIdInterface $externalId
     * @param array                      $context
     *
     * @return array|User
     */
    public function getByExternalId($externalId, array $context = [])
    {
        return $this->requestGet($context, '/user/get', ['ExternalId' => $this->toExternalId($externalId)]);
    }

    /**
     * @param string $token
     * @param array  $context
     *
     * @return array|User
     */
    public function getByToken($token, array $context = [])
    {
        return $this->requestGet($context, '/user/auth', ['token' => $token]);
    }

    /**
     * @param array $data
     * @param array $context
     *
     * @return array|User
     */
    public function create(array $data, array $context = [])
    {
        return $this->requestPost($context, '/user/create', $data);
    }

    /**
     * @param array $data
     * @param array $context
     *
     * @return array|User
     */
    public function edit(array $data, array $context = [])
    {
        return $this->requestPost($context, '/user/edit', $data);
    }

    /**
     * @param int|RunetIdInterface $runetId
     * @param array                $context
     *
     * @return array|Address
     */
    public function address($runetId, array $context = [])
    {
        return $this->requestGet($context, '/user/address', ['RunetId' => $this->toRunetId($runetId)]);
    }
}
