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
     * @param array $roles
     * @return User[]
     */
    public function users($maxResults = null, array $roles = [])
    {
        $remain = $maxResults;
        $token = null;
        $users = [];

        while ($remain > 0) {
            $response = $this->apiClient->get('event/users', [
                'MaxResults' => $remain,
                'RoleId' => $roles,
                'PageToken' => $token,
            ]);
            $data = $this->processResponse($response);

            if (!isset($data['NextPageToken'])) {
                break;
            }

            $token = $data['NextPageToken'];
            $users = array_merge($users, $data['Users']);
            $remain = $maxResults - count($users);
        }

        return $this->modelReconstructor->reconstruct($users, 'user[]');
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
