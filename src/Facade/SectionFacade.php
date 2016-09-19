<?php

namespace RunetId\ApiClient\Facade;

use DateTime;
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
     * Получение информации о секции
     *
     * @param bool $withReports
     * @return Section
     */
    public function get($withReports = false)
    {
        $response = $this->apiClient->get('section/info', array(
            'SectionId' => $this->getSectionId(),
        ));

        /** @var Section $section */
        $section = $this->processResponse($response, 'section');

        if ($withReports) {
            $section->Reports = $this->getReports();
        }

        return $section;
    }

    /**
     * Получение информации о секции
     *
     * @param bool $withReports
     * @return Section
     * @deprecated method is deprecated since version 2.1.9 and will be removed in 3.0
     * @see        SectionFacade::get
     */
    public function info($withReports = false)
    {
        @trigger_error(
            'The "'.__METHOD__.'" method is deprecated since version 2.1.9 and will be removed in version 3.0. Use the "'.__CLASS__.'::get()" method instead.',
            E_USER_DEPRECATED
        );

        return $this->get($withReports);
    }

    /**
     * Получение всех секций
     *
     * @param DateTime $fromUpdateTime
     * @param bool     $withDeleted
     * @param bool     $withReports
     * @return Section[]
     */
    public function getAll(DateTime $fromUpdateTime = null, $withDeleted = false, $withReports = false)
    {
        $response = $this->apiClient->get('section/list', array(
            'FromUpdateTime' => $fromUpdateTime ? $this->formatDateTime($fromUpdateTime) : null,
            'WithDeleted' => (bool)$withDeleted,
        ));

        /** @var Section[] $sections */
        $sections = $this->processResponse($response, 'section[]');

        if ($withReports) {
            foreach ($sections as $section) {
                $section->Reports = $this->getReportsBySectionId($section->Id, $fromUpdateTime, $withDeleted);
            }
        }

        return $sections;
    }

    /**
     * Получение всех секций, в которых участвует пользователь (независимо от роли)
     *
     * @param User|int $userOrRunetId
     * @return Section[]
     */
    public function getByUser($userOrRunetId)
    {
        if ($userOrRunetId instanceof User) {
            $userOrRunetId = $userOrRunetId->RunetId;
        }

        $response = $this->apiClient->get('section/user', array(
            'RunetId' => $userOrRunetId,
        ));

        return $this->processResponse($response, 'section[]');
    }

    /**
     * Получение докладов в секции
     *
     * @param DateTime $fromUpdateTime
     * @param bool     $withDeleted
     * @return Section\Report[]
     */
    public function getReports(DateTime $fromUpdateTime = null, $withDeleted = false)
    {
        return $this->getReportsBySectionId($this->getSectionId(), $fromUpdateTime, $withDeleted);
    }

    /**
     * Получение докладов в секции
     *
     * @param DateTime $fromUpdateTime
     * @param bool     $withDeleted
     * @return Section\Report[]
     * @deprecated method is deprecated since version 2.1.9 and will be removed in 3.0
     * @see        SectionFacade::getReports
     */
    public function reports(DateTime $fromUpdateTime = null, $withDeleted = false)
    {
        @trigger_error(
            'The "'.__METHOD__.'" method is deprecated since version 2.1.9 and will be removed in version 3.0. Use the "'.__CLASS__.'::get()" method instead.',
            E_USER_DEPRECATED
        );

        return $this->getReports($fromUpdateTime, $withDeleted);
    }

    /**
     * @param int $runetId
     * @param int $sectionId
     * @return bool
     */
    public function addFavorite($runetId, $sectionId)
    {
        $response = $this->apiClient->post('section/addFavorite', array(
            'RunetId' => $runetId,
            'SectionId' => $sectionId,
        ));

        $data = $this->processResponse($response);

        return (bool)$data['Success'];
    }

    /**
     * @param int $runetId
     * @param int $sectionId
     * @return bool
     */
    public function deleteFavorite($runetId, $sectionId)
    {
        $response = $this->apiClient->post('section/deleteFavorite', array(
            'RunetId' => $runetId,
            'SectionId' => $sectionId,
        ));

        $data = $this->processResponse($response);

        return (bool)$data['Success'];
    }

    /**
     * @param int           $runetId
     * @param DateTime|null $fromUpdateTime
     * @param bool          $withDeleted
     * @return Section\Favorite[]
     */
    public function getFavorites($runetId, DateTime $fromUpdateTime = null, $withDeleted = false)
    {
        $response = $this->apiClient->post('section/favorites', array(
            'RunetId' => $runetId,
            'FromUpdateTime' => $fromUpdateTime ? $this->formatDateTime($fromUpdateTime) : null,
            'WithDeleted' => $withDeleted,
        ));

        return $this->processResponse($response, 'section_favorite[]');
    }

    /**
     * Возвращает id секции, присвоенный текущему экземпляру фасада
     *
     * @return int
     * @throws MissingArgumentException
     */
    protected function getSectionId()
    {
        if (!isset($this->sectionId)) {
            throw new MissingArgumentException('SectionId is not set');
        }

        return $this->sectionId;
    }

    /**
     * @param int      $sectionId
     * @param DateTime $fromUpdateTime
     * @param bool     $withDeleted
     * @return Section\Report[]
     */
    protected function getReportsBySectionId(
        $sectionId,
        DateTime $fromUpdateTime = null,
        $withDeleted = false
    ) {
        $response = $this->apiClient->get('section/reports', array(
            'SectionId' => $sectionId,
            'FromUpdateTime' => $fromUpdateTime ? $this->formatDateTime($fromUpdateTime) : null,
            'WithDeleted' => (bool)$withDeleted,
        ));

        return $this->processResponse($response, 'section_report[]');
    }
}
