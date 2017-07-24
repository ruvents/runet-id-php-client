<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Iterator\UserIterator;
use RunetId\ApiClient\Model\Event\Event;
use RunetId\ApiClient\Model\Event\Role;
use RunetId\ApiClient\Model\Event\RoleIdInterface;
use RunetId\ApiClient\Model\User\User;
use RunetId\ApiClient\Model\User\UserRunetIdInterface;

class EventFacade extends AbstractFacade
{
    /**
     * @param int|UserRunetIdInterface $runetId
     * @param int|RoleIdInterface      $roleId
     * @param array                    $context
     *
     * @return true|array
     */
    public function changeRole($runetId, $roleId, array $context = [])
    {
        return $this->requestPost($context, '/event/changerole', [
            'RunetId' => ArgHelper::getUserRunetId($runetId),
            'RoleId' => ArgHelper::getEventRoleId($roleId),
        ]);
    }

    /**
     * @param array $context
     *
     * @return array|Event
     */
    public function get(array $context = [])
    {
        return $this->requestGet($context, '/event/info');
    }

    /**
     * @param int|UserRunetIdInterface $runetId
     * @param int|RoleIdInterface      $roleId
     * @param array                    $context
     *
     * @return true|array
     */
    public function register($runetId, $roleId, array $context = [])
    {
        return $this->requestPost($context, '/event/register', [
            'RunetId' => ArgHelper::getUserRunetId($runetId),
            'RoleId' => ArgHelper::getEventRoleId($roleId),
        ]);
    }

    /**
     * @param array $context
     *
     * @return array|Role[]
     */
    public function roles(array $context = [])
    {
        return $this->requestGet($context, '/event/roles');
    }

    /**
     * @param null|int $maxResults
     * @param array    $context
     *
     * @return array|UserIterator|User[]
     */
    public function users($maxResults = null, array $context = [])
    {
        return $this->requestGet($context, '/event/users', [
            'MaxResults' => $maxResults,
        ]);
    }
}
