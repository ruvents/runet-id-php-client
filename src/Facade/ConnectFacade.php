<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Connect\Place;
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
     * @return Place[]
     */
    public function getPlaces()
    {
        $response = $this->apiClient->get('connect/places');

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Places'], 'connect_place[]');
    }
}
