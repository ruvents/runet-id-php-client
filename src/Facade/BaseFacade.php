<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\ResponseException;
use RunetId\ApiClient\ModelReconstructor;
use Ruvents\HttpClient\Response\Response;

/**
 * Class BaseFacade
 */
abstract class BaseFacade
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

    /**
     * @param string $path
     * @param array  $params
     * @param int    $maxResults
     * @param string $usefulDataOffset
     * @return array
     */
    protected function getPaginatedData($path, array $params, $maxResults, $usefulDataOffset)
    {
        $pageToken = null;
        $usefulData = [];

        while (!isset($maxResults) || $maxResults > 0) {
            $params['MaxResults'] = $maxResults;
            $params['PageToken'] = $pageToken;

            $response = $this->apiClient->get($path, $params);
            $responseData = $this->processResponse($response);

            if (empty($responseData) || empty($responseData[$usefulDataOffset])) {
                break;
            }

            $usefulData = array_merge($usefulData, $responseData[$usefulDataOffset]);

            if (empty($responseData['NextPageToken'])) {
                break;
            }

            $pageToken = $responseData['NextPageToken'];

            if (isset($maxResults)) {
                $maxResults -= count($usefulData);
            }
        }

        return $usefulData;
    }
}
