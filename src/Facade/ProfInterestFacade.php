<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\ProfInterest;

/**
 * Class ProfInterestFacade
 * @package RunetId\ApiClient\Facade
 */
class ProfInterestFacade extends BaseFacade
{
    /**
     * @return ProfInterest[]
     */
    public function getAll()
    {
        $response = $this->apiClient->get('professionalinterest/list');

        return $this->processResponse($response, 'prof_interest[]');
    }
}
