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
     * @param int      $limit
     * @param \Closure $requestMaker
     * @param \Closure $dataExtractor
     * @return array
     */
    protected function collectDataRecursively($limit, \Closure $requestMaker, \Closure $dataExtractor)
    {
        $pageToken = null;
        $usefulData = [];

        while (!isset($limit) || $limit > 0) {
            /** @var Response $response */
            $response = $requestMaker($this->apiClient, $limit, $pageToken);
            $responseData = $this->processResponse($response);

            if (empty($responseData)) {
                break;
            }

            /** @var array $newUsefulData */
            $newUsefulData = $dataExtractor($responseData);
            $usefulData = array_merge($usefulData, $newUsefulData);

            if (empty($responseData['NextPageToken'])) {
                break;
            }

            $pageToken = $responseData['NextPageToken'];

            if (isset($limit)) {
                $limit -= count($usefulData);
            }
        }

        return $usefulData;
    }

    /**
     * @param Response    $response
     * @param null|string $modelName
     * @throws ResponseException
     * @return Response|object
     */
    protected function processResponse(Response $response, $modelName = null)
    {
        $data = $response->jsonDecode(true);

        if (isset($data['Error'])) {
            throw new ResponseException($data['Error']['Message'], $data['Error']['Code']);
        }

        if (isset($modelName)) {
            return $this->modelReconstructor->reconstruct($data, $modelName);
        }

        return $data;
    }
}
