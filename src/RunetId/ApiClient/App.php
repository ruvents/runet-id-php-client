<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Exception\RuntimeException;
use RunetId\ApiClient\HttpClient\HttpClientFactory;

/**
 * Class App
 * @package RunetId\ApiClient
 */
class App
{
    /**
     * Host name
     */
    const HOST = 'api.runet-id.com';

    /**
     * @var array
     */
    private $options = [
        'secure' => false,
        'http_client' => 'guzzle',
    ];

    /**
     * @var HttpClientFactory
     */
    private $httpClientFactory;

    /**
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options)
    {
        $mergedOptions = array_merge($this->options, $options);

        InvalidArgumentException::check($mergedOptions['key'], '');
        InvalidArgumentException::check($mergedOptions['secret'], '');
        InvalidArgumentException::check($mergedOptions['secure'], true);
        InvalidArgumentException::check($mergedOptions['http_client'], '');

        $this->options = $mergedOptions;

        $this->httpClientFactory = new HttpClientFactory($this);
    }

    /**
     * @return HttpClientFactory
     */
    public function getHttpClientFactory()
    {
        return $this->httpClientFactory;
    }

    /**
     * @param string $path
     * @param array  $data
     * @param array  $headers
     * @return Response
     */
    public function get($path, array $data = [], array $headers = [])
    {
        return $this->request(Request::GET, $path, $data, $headers);
    }

    /**
     * @param string $path
     * @param array  $data
     * @param array  $headers
     * @return Response
     */
    public function post($path, array $data = [], array $headers = [])
    {
        return $this->request(Request::POST, $path, $data, $headers);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $data
     * @param array  $headers
     * @throws RuntimeException
     * @return Response
     */
    public function request($method, $path, array $data = [], array $headers = [])
    {
        $request = $this->createRequest($method, $path, $data, $headers);

        $httpClient = $this->httpClientFactory
            ->getHttpClient($this->options['http_client']);

        $response = $httpClient->sendRequest($request);

        if (!$response instanceof Response) {
            throw new RuntimeException(sprintf(
                'The "%s" HTTP client must return an instance of "%s"',
                $this->options['http_client'],
                Response::class
            ));
        }

        return $response;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $data
     * @param array  $headers
     * @return Request
     */
    protected function createRequest($method, $path, array $data = [], array $headers = [])
    {
        $request = new Request(self::HOST, $path);

        $timestamp = time();
        $hash = $this->generateHash($this->options['key'], $timestamp, $this->options['secret']);
        $query = [
            'ApiKey' => $this->options['key'],
            'Timestamp' => $timestamp,
            'Hash' => $hash,
        ];

        $request
            ->setMethod($method)
            ->setSecure((bool)$this->options['secure'])
            ->setQuery($query)
            ->setData($data)
            ->setHeaders($headers);

        return $request;
    }

    /**
     * @param string $key
     * @param int    $timestamp
     * @param string $secret
     * @return string
     */
    private function generateHash($key, $timestamp, $secret)
    {
        return substr(md5($key.$timestamp.$secret), 0, 16);
    }
}
