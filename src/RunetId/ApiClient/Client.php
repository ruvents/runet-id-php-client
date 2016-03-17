<?php

namespace RunetId\ApiClient;

use Ruvents\HttpClient\HttpClient;
use Ruvents\HttpClient\Request\Request;
use Ruvents\HttpClient\Request\Uri;
use Ruvents\HttpClient\Response\Response;

/**
 * Class Client
 * @package RunetId\ApiClient
 */
class Client
{
    /**
     * @var array
     */
    protected $options = [
        'host' => 'api.runet-id.com',
        'secure' => false,
    ];

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $query
     * @param mixed  $data
     * @param array  $headers
     * @param array  $files
     * @return Response
     */
    public function request($method, $path, array $query = [], $data = null, array $headers = [], array $files = [])
    {
        $this->prepareQuery($query);

        $uri = Uri::createHttp($this->options['host'], $path, $query, $this->options['secure']);

        $request = new Request($uri, $data, $headers, $files);

        return $this->getHttpClient()->send($request, $method);
    }

    /**
     * @param string $path
     * @param array  $query
     * @param array  $headers
     * @return Response
     */
    public function get($path, array $query = [], array $headers = [])
    {
        return $this->request(HttpClient::METHOD_GET, $path, $query, null, $headers);
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
        return $this->request(HttpClient::METHOD_POST, $path, $query, $data, $headers, $files);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (!isset($this->httpClient)) {
            $this->httpClient = new HttpClient();
        }

        return $this->httpClient;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->options['key'] = $key;

        return $this;
    }

    /**
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->options['secret'] = $secret;

        return $this;
    }

    /**
     * @return array
     */
    public function getSupportedMethods()
    {
        return [HttpClient::METHOD_GET, HttpClient::METHOD_POST];
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
