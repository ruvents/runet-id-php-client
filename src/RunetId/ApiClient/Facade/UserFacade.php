<?php

namespace RunetId\ApiClient\Facade;

use Ruvents\HttpClient\Response\Response;

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
     * @param int|null $runetId
     * @return $this
     */
    public function setParams($runetId = null)
    {
        $this->runetId = $runetId;

        return $this;
    }

    /**
     * @param int|null $runetId
     * @return Response
     */
    public function get($runetId = null)
    {
        $runetId = intval($runetId ?: $this->runetId);

        $response = $this->apiClient->get('user/get', ['RunetId' => $runetId]);

        return $this->deserialize($response, 'user');
    }
}
