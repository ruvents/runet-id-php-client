<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Event\Event;

class EventFacade extends AbstractFacade
{
    /**
     * @param array $context
     *
     * @return array|Event
     */
    public function get(array $context = [])
    {
        return $this->requestGet('/event/info', [], $context);
    }
}
