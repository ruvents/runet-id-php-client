<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Model\ProfInterest;

/**
 * Class ProfInterestFacade
 * @package RunetId\ApiClient\Facade
 */
class ProfInterestFacade extends BaseFacade
{
    /**
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        parent::__construct($apiClient);
    }

    /**
     * @return ProfInterest[]
     */
    public function getAll()
    {
        $response = $this->apiClient->get('professionalinterest/list');

        return $this->processResponse($response, 'prof_interest[]');
    }
}
