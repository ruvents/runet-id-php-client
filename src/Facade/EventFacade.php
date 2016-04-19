<?php
namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Model\Event;

class EventFacade extends BaseFacade
{
    /**
     * @return Event
     */
    public function get()
    {
        $response = $this->apiClient->get('event/info');

        return $this->processResponse($response, 'event');
    }
}