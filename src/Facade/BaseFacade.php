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
     * @return mixed
     */
    protected function processResponse(Response $response, $modelName = null)
    {
        if ($response->getCode() !== 200) {
            throw new ResponseException(
                sprintf('Server responded with %s status code.', $response->getCode()),
                0, null, $response
            );
        }

        $data = $response->jsonDecode(true);

        if (isset($data['Error'])) {
            throw new ResponseException($data['Error']['Message'], $data['Error']['Code'], null, $response);
        }

        if (isset($modelName)) {
            return $this->modelReconstructor->reconstruct($data, $modelName);
        }

        return $data;
    }

    /**
     * Получает методом GET данные, разбитые на страницы с учетом переданного ограничения
     *
     * @param string   $path           путь для GET запроса
     * @param array    $query          параметры GET запроса
     * @param int|null $maxResults     максимум результатов, которые требуется получить
     *                                 (если null, вернутся все имеющиеся)
     * @param string   $dataOffset     ключ в возвращаемом массиве с данными,
     *                                 содержащий реальные данные.
     *                                 например, 'Users' для метода user.search
     *
     * @return array
     */
    protected function getPaginatedData($path, array $query, $maxResults, $dataOffset)
    {
        $data = array();

        do {
            if (null !== $maxResults) {
                $query['MaxResults'] = $maxResults;
            }

            $response = $this->apiClient->get($path, $query)->jsonDecode(true);
            $data = array_merge($data, $response[$dataOffset]);

            if (!isset($response['NextPageToken'])) {
                break;
            }

            $query['PageToken'] = $response['NextPageToken'];

            if (null === $maxResults) {
                $maxResults = $response['TotalCount'];
            }
        } while (($maxResults -= 200) > 0);

        return $data;
    }
}
