<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Exception\ResponseException;
use RunetId\ApiClient\ModelReconstructor;
use Ruvents\HttpClient\Response\Response;

/**
 * Базовый абстрактный фасад
 */
abstract class BaseFacade
{
    /**
     * Значение $maxResults по умолчанию
     */
    const DEFAULT_MAX_RESULTS = 200;

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
     * Форматирует дату для передачи в запросе
     *
     * @param \DateTime $dateTime
     * @return string
     */
    public function formatDateTime(\DateTime $dateTime)
    {
        return $dateTime->format('c');
    }

    /**
     * Обрабатывает запрос и денормализует данные.
     * Если вернулась ошибка, генерирует Exception.
     *
     * @param Response    $response  объект ответа
     * @param null|string $modelName имя модели
     *                               (если не задано, вернется неденормализованный массив данных)
     * @throws ResponseException
     * @return array|object
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
     * Получает методом GET данные, разбитые на страницы с учетом переданного ограничения
     *
     * @param string $path             путь для GET запроса
     * @param array  $params           параметры GET запроса
     * @param int    $maxResults       максимум результатов, которые требуется получить
     *                                 (если null, вернутся все имеющиеся)
     * @param string $usefulDataOffset ключ в возвращаемом массиве с данными,
     *                                 содержащий реальные данные.
     *                                 например, 'Users' для метода user.search
     * @return array
     */
    protected function getPaginatedData($path, array $params, $maxResults, $usefulDataOffset)
    {
        $pageToken = null;
        $usefulData = array();

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
