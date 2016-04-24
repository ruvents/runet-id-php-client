<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Event;

/**
 * Class EventFacade
 */
class EventFacade extends BaseFacade
{
    /**
     * Получение информации о мероприятии
     * @return Event
     */
    public function get()
    {
        $response = $this->apiClient->get('event/info');

        return $this->processResponse($response, 'event');
    }

    /**
     * Регистрация на мероприятие
     *
     * @param int  $runetId
     * @param int  $roleId      роль по умолчанию - 1 - участник
     * @param bool $usePriority использовать системные приоритеты статусов
     * @return bool
     */
    public function register($runetId, $roleId = 1, $usePriority = true)
    {
        $response= $this->apiClient->post('event/register', [
            'RunetId' => $runetId,
            'RoleId' => $roleId,
            'UsePriority' => $usePriority,
        ]);

        $this->processResponse($response);

        return true;
    }
}
