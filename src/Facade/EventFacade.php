<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Exception\InvalidArgumentException;
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
        if ($roles) {
            foreach ($roles as $role) {
                if (!in_array($role, User\Status::getRoles())) {
                    throw new InvalidArgumentException(sprintf(
                        'Role "%u" does not exist',
                        $role
                    ));
                }
            }
        }

        $response = $this->apiClient->get('event/users', [
            'MaxResults' => $maxResults,
            'RoleId' => $roles,
        ]);

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Users'], 'user[]');
    }

    /**
     * Изменение роли на мероприятии
     *
     * @param int $RunetId
     * @param int $RoleId
     * @return bool
     */
    public function changeRole($RunetId, $RoleId)
    {
        $response = $this->apiClient->post('event/changerole', [
            'RunetId' => $RunetId,
            'RoleId' => $RoleId,
        ]);

        $data = $this->processResponse($response);

        return (bool)$data['Success'];
    }
}
