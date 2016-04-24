<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\MissingArgumentException;
use RunetId\ApiClient\Model\NewUser;
use RunetId\ApiClient\Model\ProfInterest;
use RunetId\ApiClient\Model\User;
use RunetId\ApiClient\ModelReconstructor;
use Ruvents\HttpClient\Request\File;

/**
 * Class UserFacade
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
     * @param int|null           $sectionId
     */
    public function __construct(
        ApiClient $apiClient,
        ModelReconstructor $modelReconstructor,
        $sectionId = null
    ) {
        parent::__construct($apiClient, $modelReconstructor);
        $this->runetId = $sectionId ? (int)$sectionId : null;
    }

    /**
     * @return User
     */
    public function get()
    {
        $response = $this->apiClient->get('user/get', [
            'RunetId' => $this->getRunetId(),
        ]);

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
            ['RunetId' => $this->getRunetId()], null, [], ['Image' => $file]
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
            'RunetId' => $this->getRunetId(),
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
            'RunetId' => $this->getRunetId(),
            'ProfessionalInterestId' => $profInterestOrId,
        ]);
    }

    /**
     * @param string $query
     * @param int    $maxResults
     * @return User[]
     */
    public function search($query, $maxResults = null)
    {
        $response = $this->apiClient->get('user/search', [
            'Query' => $query,
            'MaxResults' => $maxResults,
        ]);

        $data = $this->processResponse($response);

        return $this->modelReconstructor->reconstruct($data['Users'], 'user[]');
    }

    /**
     * @param NewUser $user
     * @return User
     */
    public function create(NewUser $user)
    {
        $response = $this->apiClient->post('user/create', [], get_object_vars($user));

        return $this->processResponse($response, 'user');
    }

    /**
     * @return bool
     */
    public function isParticipant()
    {
        return isset($this->get()->Status);
    }

    /**
     * @throws MissingArgumentException
     * @return int
     */
    protected function getRunetId()
    {
        if (!isset($this->runetId)) {
            throw new MissingArgumentException('RunetId is not set');
        }

        return $this->runetId;
    }
}
