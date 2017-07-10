<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Event\Event;
use RunetId\ApiClient\Model\Event\Role;

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
}
