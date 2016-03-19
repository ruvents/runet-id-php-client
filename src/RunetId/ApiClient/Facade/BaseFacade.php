<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use Ruvents\HttpClient\Response\Response;

/**
 * Class DefaultFacade
 * @package RunetId\ApiClient\Facade
 */
class BaseFacade
{
    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param string|Response $response
     * @param string          $modelName
     * @param bool            $isArray
     * @return object
     */
    public function deserialize($response, $modelName, $isArray = false)
    {
        return $this->apiClient->deserialize($response, $modelName, $isArray);
    }
}
