<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Facade\UserFacade;
use Ruvents\HttpClient\HttpClient;
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
            'error' => 'RunetId\ApiClient\Model\Error',
            'user' => 'RunetId\ApiClient\Model\User',
        ],
    ];

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
        $this->serializer = new Serializer(
            [new ObjectNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @param string $path
     * @param array  $data
     * @param array  $headers
     * @return Response
     */
    public function get($path, array $data = [], array $headers = [])
    {
        $this->prepareQuery($data);
        $uri = Uri::createHttp($this->options['host'], $path, [], $this->options['secure']);

        return HttpClient::get($uri, $data, $headers);
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

        return HttpClient::post($uri, $data, $headers, $files);
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
     * @param mixed  $data
     * @param string $model
     * @return object
     */
    public function denormalize($data, $model)
    {
        if ($data instanceof Response) {
            $data = $data->jsonDecode(true);
        }

        $className = $this->getModelClass($model);

        return $this->serializer->denormalize($data, $className);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getModelClass($name)
    {
        $isArray = false;

        if (substr($name, -2) === '[]') {
            $name = substr($name, 0, -2);
            $isArray = true;
        }

        if (!isset($this->options['model_classes'][$name])) {
            throw new InvalidArgumentException(
                InvalidArgumentException::haystackMsg(
                    array_keys($this->options['model_classes'])
                )
            );
        }

        return $this->options['model_classes'][$name].($isArray ? '[]' : '');
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
