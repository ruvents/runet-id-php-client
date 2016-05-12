<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Event;
use RunetId\ApiClient\Model\User;

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
     * @param int  $roleId
     * @param bool $usePriority использовать системные приоритеты статусов
     * @return bool
     */
    public function register($runetId, $roleId = User\Status::ROLE_PARTICIPANT, $usePriority = true)
    {
        $response = $this->apiClient->post('event/register', [
            'RunetId' => $runetId,
            'RoleId' => $roleId,
            'UsePriority' => $usePriority,
        ]);

        $this->processResponse($response);

        return true;
    }

    /**
     * @param int   $maxResults
     * @param array $roleIds
     * @return User[]
     */
    public function users($maxResults = null, array $roleIds = [])
    {
        $data = $this->getPaginatedData('event/users', ['RoleId' => $roleIds], $maxResults, 'Users');

        return $this->modelReconstructor->reconstruct($data, 'user[]');
    }

    /**
     * Изменение роли на мероприятии
     *
     * @param int $runetId
     * @param int $roleId
     * @return bool
     */
    public function changeRole($runetId, $roleId)
    {
        $response = $this->apiClient->post('event/changerole', [
            'RunetId' => $runetId,
            'RoleId' => $roleId,
        ]);

        $data = $this->processResponse($response);

        return (bool)$data['Success'];
    }
}
