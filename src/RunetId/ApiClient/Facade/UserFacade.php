<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
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
     * @param ApiClient $apiClient
     * @param int|null  $runetId
     */
    public function __construct(ApiClient $apiClient, $runetId = null)
    {
        parent::__construct($apiClient);
        $this->runetId = $runetId;
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
