<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\ResponseException;
use RunetId\ApiClient\ModelReconstructor;
use Ruvents\HttpClient\Response\Response;

/**
 * Class DefaultFacade
 */
class BaseFacade
{
    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * @var ModelReconstructor
     */
    protected $modelReconstructor;

    /**
     * @param ApiClient          $apiClient
     * @param ModelReconstructor $modelReconstructor
     */
    public function __construct(ApiClient $apiClient, ModelReconstructor $modelReconstructor)
    {
        $this->apiClient = $apiClient;
        $this->modelReconstructor = $modelReconstructor;
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function formatDateTime(\DateTime $dateTime)
    {
        return $dateTime->format('c');
    }

    /**
     * @param string|Response $response
     * @param null|string     $modelName
     * @throws ResponseException
     * @return Response|object
     */
    protected function processResponse($response, $modelName = null)
    {
        $data = $response->jsonDecode(true);

        if (isset($data['Error'])) {
            throw new ResponseException($data['Error']['Message'], $data['Error']['Code']);
        }

        if (isset($modelName)) {
            return $this->modelReconstructor->reconstruct($data, $modelName);
        }

        return $response;
    }
}
