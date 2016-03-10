<?php

namespace RunetId\ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Exception\UnexpectedValueException;

class Client
{
    /**
     * GET method name
     */
    const METHOD_GET = 'GET';

    /**
     * POST method name
     */
    const METHOD_POST = 'POST';

    /**
     * @var array
     */
    private $options = [
        'host' => 'api.runet-id.com',
        'secure' => false,
    ];

    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options)
    {
        $mergedOptions = array_merge($this->options, $options);

        InvalidArgumentException::check($mergedOptions['host'], '');
        InvalidArgumentException::check($mergedOptions['secure'], true);
        InvalidArgumentException::check($mergedOptions['key'], '');
        InvalidArgumentException::check($mergedOptions['secret'], '');

        $this->options = $mergedOptions;
    }

    /**
     * @return array
     */
    public function getSupportedMethods()
    {
        return [self::METHOD_GET, self::METHOD_POST];
    }

    /**
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        if (!isset($this->guzzleClient)) {
            $this->guzzleClient = new GuzzleClient();
        }

        return $this->guzzleClient;
    }

    /**
     * @param string $path
     * @param array  $query
     * @param array  $headers
     * @return Response
     */
    public function get($path, array $query = [], array $headers = [])
    {
        return $this->request(self::METHOD_GET, $path, $query, [], $headers);
    }

    /**
     * @param string $path
     * @param array  $query
     * @param array  $data
     * @param array  $headers
     * @return Response
     */
    public function post($path, array $query = [], array $data = [], array $headers = [])
    {
        return $this->request(self::METHOD_POST, $path, $query, $data, $headers);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $query
     * @param array  $data
     * @param array  $headers
     * @throws UnexpectedValueException|InvalidArgumentException
     * @return Response
     */
    public function request($method, $path, array $query = [], array $data = [], array $headers = [])
    {
        UnexpectedValueException::check($method, $this->getSupportedMethods());
        InvalidArgumentException::check($path, '');

        $path = trim($path, '/');
        $timestamp = time();
        $hash = $this->generateHash($this->options['key'], $this->options['secret'], $timestamp);

        $query = array_merge([
            'ApiKey' => $this->options['key'],
            'Timestamp' => $timestamp,
            'Hash' => $hash,
        ], $query);

        $uri = (new Uri())
            ->withHost($this->options['host'])
            ->withScheme('http'.($this->options['secure'] ? 's' : ''))
            ->withPath($path);

        $request = new Request($method, $uri, $headers);

        return $this->getGuzzleClient()->send($request, [
            'query' => $query,
            'form_params' => $data,
        ]);
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
