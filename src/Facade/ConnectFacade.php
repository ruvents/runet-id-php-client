<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Connection;
use RunetId\ApiClient\Model\Connection\Place;
use RunetId\ApiClient\Model\User;

class ConnectFacade extends BaseFacade
{
    /**
     * @param int $runetId
     * @return User[]
     */
    public function getRecommendations($runetId)
    {
        $response = $this->apiClient->get('connect/recommendations', array(
            'RunetId' => $runetId,
        ));

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Users'], 'user[]');
    }

    /**
     * @param int      $runetId
     * @param int      $roleId
     * @param string[] $attributes
     * @return User[]
     */
    public function search($runetId, $roleId = null, array $attributes = array())
    {
        $response = $this->apiClient->get('connect/search', array(
            'RunetId' => $runetId,
            'RoleId' => $roleId,
            'Attributes' => $attributes,
        ));

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Users'], 'user[]');
    }

    /**
     * @param array $parameters
     * @return Connection
     */
    public function create(array $parameters)
    {
        $response = $this->apiClient->post('connect/create', $parameters);

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Meeting'], 'connection');
    }

    /**
     * @return Place[]
     */
    public function getPlaces()
    {
        $response = $this->apiClient->get('connect/places');

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Places'], 'connection_place[]');
    }

    /**
     * @param array $parameters
     * @return Connection[]
     */
    public function getConnections($parameters = array())
    {
        $response = $this->apiClient->get('connect/list', $parameters);

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Meetings'], 'connection[]');
    }

    /**
     * @param int $runetId
     * @param int $meetingId
     * @return bool
     */
    public function signup($runetId, $meetingId)
    {
        $response = $this->apiClient->post('connect/signup', array(
            'RunetId' => $runetId,
            'MeetingId' => $meetingId,
        ));

        $data = $this->processResponse($response);

        return $data['Success'];
    }

    /**
     * @param int    $runetId
     * @param int    $meetingId
     * @param string $response
     * @return bool
     */
    public function accept($runetId, $meetingId, $response = '')
    {
        $response = $this->apiClient->post('connect/accept', array(
            'RunetId' => $runetId,
            'MeetingId' => $meetingId,
            'Response' => $response,
        ));

        $data = $this->processResponse($response);

        return $data['Success'];
    }

    /**
     * @param int    $runetId
     * @param int    $meetingId
     * @param string $response
     * @return bool
     */
    public function decline($runetId, $meetingId, $response = '')
    {
        $response = $this->apiClient->post('connect/decline', array(
            'RunetId' => $runetId,
            'MeetingId' => $meetingId,
            'Response' => $response,
        ));

        $data = $this->processResponse($response);

        return $data['Success'];
    }
}
