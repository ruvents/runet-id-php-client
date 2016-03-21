<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\ApiException;
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
     * @param null|string     $expectedModel
     * @throws ApiException
     * @return Response|object
     */
    protected function processResponse($response, $expectedModel = null)
    {
        $data = $response->jsonDecode(true);

        if (isset($data['Error'])) {
            throw new ApiException($data['Error']['Message'], $data['Error']['Code']);
        }

        if (isset($expectedModel)) {
            return $this->apiClient->denormalize($data, $expectedModel);
        }

        return $response;
    }
}
