<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Event;
use RunetId\ApiClient\Model\EventRole;
use RunetId\ApiClient\Model\User;

/**
 * Class EventFacade
 */
class EventFacade extends BaseFacade
{
    /**
     * Получение информации о мероприятии
     *
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
        $response = $this->apiClient->post('event/register', array(
            'RunetId' => $runetId,
            'RoleId' => $roleId,
            'UsePriority' => $usePriority,
        ));

        $this->processResponse($response);

        return true;
    }

    /**
     * @param int        $maxResults
     * @param array      $roleIds
     * @param null|array $builders
     * @return User[]
     */
    public function users(
        $maxResults = self::DEFAULT_MAX_RESULTS,
        array $roleIds = array(),
        $builders = null
    ) {
        $data = $this->getPaginatedData('event/users',
            array('RoleId' => $roleIds, 'Builders' => $builders),
            $maxResults,
            'Users'
        );

        return $this->modelReconstructor->reconstruct($data, 'user[]');
    }

    /**
     * Возвращает список статусов участия, доступных на мероприятии.
     *
     * @return EventRole[]
     */
    public function roles()
    {
        $roles = $this->processResponse(
            $this->apiClient->get('event/roles')
        );

        return $this->modelReconstructor
            ->reconstruct($roles, 'event_role[]');
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
        $response = $this->apiClient->post('event/changerole', array(
            'RunetId' => $runetId,
            'RoleId' => $roleId,
        ));

        $data = $this->processResponse($response);

        return (bool)$data['Success'];
    }
}
