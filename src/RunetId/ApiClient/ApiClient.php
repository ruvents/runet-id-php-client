<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Facade\UserFacade;
use Ruvents\HttpClient\HttpClient;
use Ruvents\HttpClient\Request\Request;
use Ruvents\HttpClient\Request\Uri;
use Ruvents\HttpClient\Response\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class ApiClient
 * @package RunetId\ApiClient
 */
class ApiClient
{
    /**
     * @var array
     */
    protected $options = [
        'secure' => false,
        'host' => 'api.runet-id.com',
        'model_classes' => [
            'user' => 'RunetId\ApiClient\Model\User',
        ],
    ];

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        $this->httpClient = new HttpClient();
        $this->serializer = new Serializer(
            [new ObjectNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @param string $path
     * @param array  $query
     * @param array  $headers
     * @return Response
     */
    public function get($path, array $query = [], array $headers = [])
    {
        $this->prepareQuery($query);
        $uri = Uri::createHttp($this->options['host'], $path, $query, $this->options['secure']);
        $request = new Request($uri, null, $headers);

        return $this->httpClient->get($request);
    }

    /**
     * @param string $path
     * @param array  $query
     * @param mixed  $data
     * @param array  $headers
     * @param array  $files
     * @return Response
     */
    public function post($path, array $query = [], $data = null, array $headers = [], array $files = [])
    {
        $this->prepareQuery($query);
        $uri = Uri::createHttp($this->options['host'], $path, $query, $this->options['secure']);
        $request = new Request($uri, $data, $headers, $files);

        return $this->httpClient->post($request);
    }

    /**
     * @param int|null $runetId
     * @return UserFacade
     */
    public function user($runetId = null)
    {
        return new UserFacade($this, $runetId);
    }

    /**
     * @param string|Response $response
     * @param string          $modelName
     * @param bool            $isArray
     * @return object
     */
    public function deserialize($response, $modelName, $isArray = false)
    {
        if ($response instanceof Response) {
            $response = $response->getRawBody();
        }

        $className = $this->getModelClass($modelName).($isArray ? '[]' : '');

        return $this->serializer->deserialize($response, $className, 'json');
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getModelClass($name)
    {
        if (!isset($this->options['model_classes'][$name])) {
            throw new InvalidArgumentException(
                InvalidArgumentException::haystackMsg(
                    array_keys($this->options['model_classes'])
                )
            );
        }

        return $this->options['model_classes'][$name];
    }

    /**
     * @param array $query
     */
    protected function prepareQuery(array &$query)
    {
        $timestamp = time();
        $hash = $this->generateHash($this->options['key'], $this->options['secret'], $timestamp);

        $query = array_merge([
            'ApiKey' => $this->options['key'],
            'Timestamp' => $timestamp,
            'Hash' => $hash,
        ], $query);
    }

    /**
     * @param string $key
     * @param string $secret
     * @param int    $timestamp
     * @return string
     */
    private function generateHash($key, $secret, $timestamp)
    {
        return substr(md5($key.$timestamp.$secret), 0, 16);
    }
}
