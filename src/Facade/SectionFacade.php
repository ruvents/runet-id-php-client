<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\MissingArgumentException;
use RunetId\ApiClient\Model\Section;
use RunetId\ApiClient\Model\User;
use RunetId\ApiClient\ModelReconstructor;

/**
 * Class SectionFacade
 */
class SectionFacade extends BaseFacade
{
    /**
     * @var int
     */
    private $sectionId;

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
        $this->sectionId = $sectionId ? (int)$sectionId : null;
    }

    /**
     * Получение информации о конкртеной секции
     * @return Section
     */
    public function info()
    {
        $response = $this->apiClient->get('section/info', [
            'SectionId' => $this->getSectionId(),
        ]);

        return $this->processResponse($response, 'section');
    }

    /**
     * Получение всех секций
     * @param \DateTime $fromUpdateTime
     * @param bool      $withDeleted
     * @return Section[]
     */
    public function getAll(\DateTime $fromUpdateTime = null, $withDeleted = false)
    {
        $response = $this->apiClient->get('section/list', [
            'FromUpdateTime' => $fromUpdateTime ? $this->formatDateTime($fromUpdateTime) : null,
            'WithDeleted' => (bool)$withDeleted,
        ]);

        return $this->processResponse($response, 'section[]');
    }

    /**
     * @param User|int $userOrRunetId
     * @return Section[]
     */
    public function getByUser($userOrRunetId)
    {
        if ($userOrRunetId instanceof User) {
            $userOrRunetId = $userOrRunetId->RunetId;
        }

        $response = $this->apiClient->get('section/user', [
            'RunetId' => $userOrRunetId,
        ]);

        return $this->processResponse($response, 'section[]');
    }

    /**
     * Получение докладов в секции
     * @param \DateTime $fromUpdateTime
     * @param bool      $withDeleted
     * @return Section\Report[]
     */
    public function reports(\DateTime $fromUpdateTime = null, $withDeleted = false)
    {
        $response = $this->apiClient->get('section/reports', [
            'SectionId' => $this->getSectionId(),
            'FromUpdateTime' => $fromUpdateTime ? $this->formatDateTime($fromUpdateTime) : null,
            'WithDeleted' => (bool)$withDeleted,
        ]);

        return $this->processResponse($response, 'section_report[]');
    }

    /**
     * @throws MissingArgumentException
     * @return int
     */
    protected function getSectionId()
    {
        if (!isset($this->sectionId)) {
            throw new MissingArgumentException('SectionId is not set');
        }

        return $this->sectionId;
    }
}
