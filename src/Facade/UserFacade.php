<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\MissingArgumentException;
use RunetId\ApiClient\Model\ProfInterest;
use RunetId\ApiClient\Model\User;
use RunetId\ApiClient\ModelReconstructor;
use Ruvents\HttpClient\Request\File;
use Ruvents\HttpClient\Response\Response;

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
        $response = $this->apiClient->get('user/get', array(
            'RunetId' => $this->getRunetId(),
        ));

        return $this->processResponse($response, 'user');
    }

    /**
     * @param string $token
     * @return User
     */
    public function auth($token)
    {
        $response = $this->apiClient->get('user/auth', array('token' => $token));

        return $this->processResponse($response, 'user');
    }

    /**
     * @param string $token
     * @return User
     */
    public function getByToken($token)
    {
        return $this->auth($token);
    }

    /**
     * @param string|File|resource $file
     * @return User
     */
    public function setPhoto($file)
    {
        return $this->apiClient->post(
            'user/setphoto',
            array('RunetId' => $this->getRunetId()),
            null,
            array(),
            array('Image' => $file)
        );
    }

    /**
     * Устанавливаем доп атрибуты пользователя
     * @param array $attributes ['Event' => 111, 'Course' => 222 ]
     *                          Доп атрибут сначала необходимо добавить в партнерском интерфейсе, ключ массива -
     *                          символьный код доп атрибута
     * @return Response
     */
    public function setData($attributes = array())
    {
        return $this->apiClient->post('user/setdata', array(
            'RunetId' => $this->getRunetId(),
            'Attributes' => $attributes,
        ));
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

        $this->apiClient->get('professionalinterest/add', array(
            'RunetId' => $this->getRunetId(),
            'ProfessionalInterestId' => $profInterestOrId,
        ));
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

        $this->apiClient->get('professionalinterest/delete', array(
            'RunetId' => $this->getRunetId(),
            'ProfessionalInterestId' => $profInterestOrId,
        ));
    }

    /**
     * @param string $query
     * @param int    $maxResults
     * @return User[]
     */
    public function search($query, $maxResults = self::DEFAULT_MAX_RESULTS)
    {
        $data = $this->getPaginatedData('user/search', array('Query' => $query), $maxResults, 'Users');

        return $this->modelReconstructor->reconstruct($data, 'user[]');
    }

    /**
     * @param array|object $data
     * @return User
     */
    public function create($data)
    {
        if (is_object($data)) {
            @trigger_error(
                'Passig an object to user.create is deprecated since version 2.1.5 and will be removed in 3.0.',
                E_USER_DEPRECATED
            );

            $data = get_object_vars($data);
        }

        $response = $this->apiClient->post('user/create', array(), $data);

        return $this->processResponse($response, 'user');
    }

    /**
     * @param array $data
     * @return User
     */
    public function edit($data)
    {
        $response = $this->apiClient->post('user/edit', array(), $data);

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
    public function getRunetId()
    {
        if (!isset($this->runetId)) {
            throw new MissingArgumentException('RunetId is not set');
        }

        return $this->runetId;
    }
}
