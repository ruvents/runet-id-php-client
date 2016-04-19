<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Model\ProfInterest;
use RunetId\ApiClient\Model\User;
use RunetId\ApiClient\ModelReconstructor;
use Ruvents\HttpClient\Request\File;

/**
 * Class UserFacade
 * @package RunetId\ApiClient\Facade
 */
class UserFacade extends BaseFacade
{
    /**
     * @var int
     */
    private $runetId;

    /**
     * @param ApiClient          $apiClient
     * @param ModelReconstructor $modelReconstructor
     * @param int|null           $runetId
     */
    public function __construct(
        ApiClient $apiClient, ModelReconstructor $modelReconstructor,
        $runetId = null
    ) {
        parent::__construct($apiClient, $modelReconstructor);
        $this->runetId = $runetId ? (int)$runetId : null;
    }

    /**
     * @return User
     */
    public function get()
    {
        $response = $this->apiClient->get('user/get', ['RunetId' => $this->runetId]);

        return $this->processResponse($response, 'user');
    }

    /**
     * @param string $token
     * @return User
     */
    public function getByToken($token)
    {
        $response = $this->apiClient->get('user/auth', ['token' => $token]);

        return $this->processResponse($response, 'user');
    }

    /**
     * @param string|File|resource $file
     * @return User
     */
    public function setPhoto($file)
    {
        return $this->apiClient->post('user/setphoto',
            ['RunetId' => $this->runetId], null, [], ['Image' => $file]
        );
    }

    /**
     * @param int|ProfInterest $profInterestOrId
     */
    public function addProfInterest($profInterestOrId)
    {
        if ($profInterestOrId instanceof ProfInterest) {
            $profInterestOrId = $profInterestOrId->Id;
        }

        $profInterestOrId = (int)$profInterestOrId;

        $this->apiClient->get('professionalinterest/add', [
            'RunetId' => $this->runetId,
            'ProfessionalInterestId' => $profInterestOrId,
        ]);
    }

    /**
     * @param int|ProfInterest $profInterestOrId
     */
    public function removeProfInterest($profInterestOrId)
    {
        if ($profInterestOrId instanceof ProfInterest) {
            $profInterestOrId = $profInterestOrId->Id;
        }

        $profInterestOrId = (int)$profInterestOrId;

        $this->apiClient->get('professionalinterest/delete', [
            'RunetId' => $this->runetId,
            'ProfessionalInterestId' => $profInterestOrId,
        ]);
    }

    /**
     * @return bool
     */
    public function isParticipant()
    {
        return isset($this->get()->Status);
    }
}
