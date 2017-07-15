<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Iterator\UserIterator;
use RunetId\ApiClient\Model\Common\Address;
use RunetId\ApiClient\Model\User\User;
use RunetId\ApiClient\Model\User\UserRunetIdInterface;

class UserFacade extends AbstractFacade
{
    /**
     * @param int|UserRunetIdInterface $runetId
     * @param array                    $context
     *
     * @return array|Address
     */
    public function address($runetId, array $context = [])
    {
        return $this->requestGet($context, '/user/address', [
            'RunetId' => ArgHelper::getUserRunetId($runetId),
        ]);
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
     * @param int|UserRunetIdInterface $runetId
     * @param array                    $context
     *
     * @return array|User
     */
    public function get($runetId, array $context = [])
    {
        return $this->requestGet($context, '/user/get', [
            'RunetId' => ArgHelper::getUserRunetId($runetId),
        ]);
    }

    /**
     * @param string $token
     * @param array  $context
     *
     * @return array|User
     */
    public function getByToken($token, array $context = [])
    {
        return $this->requestGet($context, '/user/auth', [
            'token' => $token,
        ]);
    }

    /**
     * @param int|UserRunetIdInterface $runetId
     * @param string                   $currentPassword
     * @param string                   $newPassword
     * @param array                    $context
     *
     * @return true|array
     */
    public function changePassword($runetId, $currentPassword, $newPassword, array $context = [])
    {
        return $this->requestPost($context, '/user/passwordChange', [
            'RunetId' => ArgHelper::getUserRunetId($runetId),
            'CurrentPassword' => ArgHelper::getUserRunetId($currentPassword),
            'NewPassword' => $newPassword,
        ]);
    }

    /**
     * @param int|string|UserRunetIdInterface $credential
     * @param array                           $context
     *
     * @return true|array
     */
    public function restorePassword($credential, array $context = [])
    {
        if ($credential instanceof UserRunetIdInterface) {
            $credential = $credential->getRunetId();
        }

        return $this->requestPost($context, '/user/passwordRestore', [
            'Credential' => $credential,
        ]);
    }

    /**
     * @param string   $query
     * @param null|int $maxResults
     * @param array    $context
     *
     * @return array|UserIterator|User[]
     */
    public function search($query, $maxResults = null, array $context = [])
    {
        return $this->requestGet($context, '/user/search', [
            'Query' => $query,
            'MaxResults' => $maxResults,
        ]);
    }
}
