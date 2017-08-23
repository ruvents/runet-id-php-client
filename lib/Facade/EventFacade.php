<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Iterator\PageTokenIterator;
use RunetId\ApiClient\Model\Event\Event;
use RunetId\ApiClient\Model\Event\Status;
use RunetId\ApiClient\Model\Event\StatusIdInterface;
use RunetId\ApiClient\Model\User\User;
use RunetId\ApiClient\Model\User\UserRunetIdInterface;

class EventFacade extends AbstractFacade
{
    /**
     * @param int|UserRunetIdInterface $runetId
     * @param int|StatusIdInterface    $statusId
     * @param array                    $context
     *
     * @return true|array
     */
    public function changeStatus($runetId, $statusId, array $context = [])
    {
        return $this->requestPost($context, '/event/changerole', [
            'RunetId' => ArgHelper::getUserRunetId($runetId),
            'RoleId' => ArgHelper::getEventStatusId($statusId),
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
     * @param int|StatusIdInterface    $statusId
     * @param array                    $context
     *
     * @return true|array
     */
    public function registerUser($runetId, $statusId, array $context = [])
    {
        return $this->requestPost($context, '/event/register', [
            'RunetId' => ArgHelper::getUserRunetId($runetId),
            'RoleId' => ArgHelper::getEventStatusId($statusId),
        ]);
    }

    /**
     * @param array $context
     *
     * @return array|Status[]
     */
    public function getStatuses(array $context = [])
    {
        return $this->requestGet($context, '/event/roles');
    }

    /**
     * @param null|int $maxResults
     * @param array    $context
     *
     * @return array|PageTokenIterator|User[]
     */
    public function getUsers($maxResults = null, array $context = [])
    {
        return $this->requestGet($context, '/event/users', [
            'MaxResults' => $maxResults,
        ]);
    }
}
