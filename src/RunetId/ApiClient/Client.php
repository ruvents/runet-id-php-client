<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Exception\UnexpectedValueException;
use Unirest\Method;
use Unirest\Request;
use Unirest\Request\Body;
use Unirest\Response;

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
        return [Method::GET, Method::POST];
    }

    /**
     * @param string $path
     * @param array  $query
     * @param array  $headers
     * @return Response
     */
    public function get($path, array $query = [], array $headers = [])
    {
        return $this->request(Method::GET, $path, $query, null, $headers);
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
        return $this->request(Method::POST, $path, $query, $data, $headers, $files);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $query
     * @param mixed  $data
     * @param array  $headers
     * @param array  $files
     * @throws UnexpectedValueException|InvalidArgumentException
     * @return Response
     */
    public function request($method, $path, array $query = [], $data = null, array $headers = [], array $files = [])
    {
        UnexpectedValueException::check($method, $this->getSupportedMethods());

        $url = $this->prepareUrl($path, $query);
        $body = (new Body())->Multipart($data, empty($files) ?: $files);

        return Request::send($method, $url, $body, $headers);
    }

    /**
     * @param string $path
     * @param array  $query
     * @return string
     */
    protected function prepareUrl($path, array $query)
    {
        InvalidArgumentException::check($path, '');

        $query = $this->prepareQuery($query);

        $url = 'http'.($this->options['secure'] ? 's' : '').'://'
            .trim($this->options['host'], '/').'/'
            .trim($path, '/')
            .(empty($query) ? '' : '?'.http_build_query($query));

        return $url;
    }

    /**
     * @param array $query
     * @return array
     */
    protected function prepareQuery(array $query)
    {
        $timestamp = time();
        $hash = $this->generateHash($this->options['key'], $this->options['secret'], $timestamp);

        $query = array_merge([
            'ApiKey' => $this->options['key'],
            'Timestamp' => $timestamp,
            'Hash' => $hash,
        ], $query);

        return $query;
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
