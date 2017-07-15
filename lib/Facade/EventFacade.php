<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Iterator\UserIterator;
use RunetId\ApiClient\Model\Event\Event;
use RunetId\ApiClient\Model\Event\Role;
use RunetId\ApiClient\Model\User\User;

class EventFacade extends AbstractFacade
{
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
