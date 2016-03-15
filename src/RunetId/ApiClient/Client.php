<?php

namespace RunetId\ApiClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\RequestOptions;
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
    protected $options = [
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
        $this->setKey($mergedOptions['key']);
        $this->setSecret($mergedOptions['secret']);

        $this->options = $mergedOptions;
    }

    /**
     * @param string $key
     * @throws InvalidArgumentException
     * @return $this
     */
    public function setKey($key)
    {
        InvalidArgumentException::check($key, '');

        $this->options['key'] = $key;

        return $this;
    }

    /**
     * @param string $secret
     * @throws InvalidArgumentException
     * @return $this
     */
    public function setSecret($secret)
    {
        InvalidArgumentException::check($secret, '');

        $this->options['secret'] = $secret;

        return $this;
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
        return $this->request(self::METHOD_GET, $path, $query, null, $headers);
    }

    /**
     * @param string $path
     * @param array  $query
     * @param mixed  $data
     * @param array  $headers
     * @return Response
     */
    public function post($path, array $query = [], $data = null, array $headers = [])
    {
        return $this->request(self::METHOD_POST, $path, $query, $data, $headers);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $query
     * @param mixed  $data
     * @param array  $headers
     * @throws UnexpectedValueException|InvalidArgumentException
     * @return Response
     */
    public function request($method, $path, array $query = [], $data = null, array $headers = [])
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
        $request = new Request($method, $uri);

        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::HEADERS => $headers,
        ];
        if (!empty($data)) {
            if (is_array($data)) {
                $options[RequestOptions::FORM_PARAMS] = $data;
            } else {
                $options[RequestOptions::BODY] = $data;
            }
        }

        return $this->getGuzzleClient()->send($request, $options);
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
