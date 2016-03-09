<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Exception\UnexpectedValueException;

/**
 * Class Request
 * @package RunetId\ApiClient
 */
class Request
{
    /**
     * Get method type
     */
    const GET = 'GET';

    /**
     * Post method type
     */
    const POST = 'POST';

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $method = self::GET;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $query = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var bool
     */
    private $secure = true;

    /**
     * @param string $host
     * @param string $path
     * @param array  $data
     */
    public function __construct($host, $path, array $data = [])
    {
        $this->setHost($host);
        $this->setPath($path);
        $this->data = $data;
    }

    /**
     * @param string $host
     * @throws InvalidArgumentException
     * @return $this
     */
    public function setHost($host)
    {
        InvalidArgumentException::check($host, '');

        $this->host = trim($host, '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return array
     */
    public function getSupportedMethods()
    {
        return [self::GET, self::POST];
    }

    /**
     * @param string $method
     * @throws InvalidArgumentException|UnexpectedValueException
     * @return $this
     */
    public function setMethod($method)
    {
        InvalidArgumentException::check($method, '');
        UnexpectedValueException::check($method, $this->getSupportedMethods());

        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return bool
     */
    public function isGet()
    {
        return $this->method === self::GET;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->method === self::POST;
    }

    /**
     * @param string $path
     * @throws InvalidArgumentException
     * @return $this
     */
    public function setPath($path)
    {
        InvalidArgumentException::check($path, '');

        $this->path = '/'.ltrim($path, '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function setQuery(array $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @throws InvalidArgumentException
     * @return $this
     */
    public function addQueryParam($name, $value)
    {
        InvalidArgumentException::check($name, '');

        $this->query[$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return http_build_query($this->query);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @throws InvalidArgumentException
     * @return $this
     */
    public function addDataParam($name, $value)
    {
        InvalidArgumentException::check($name, '');

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @throws InvalidArgumentException
     * @return $this
     */
    public function addHeader($name, $value)
    {
        InvalidArgumentException::check($name, '');

        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param bool $secure
     * @throws InvalidArgumentException
     * @return $this
     */
    public function setSecure($secure)
    {
        InvalidArgumentException::check($secure, true);

        $this->secure = $secure;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return 'http'.($this->isSecure() ? 's' : '');
    }

    /**
     * @param bool $includeQuery
     * @return string
     */
    public function getUri($includeQuery = false)
    {
        return $this->getScheme().'://'.$this->getHost().$this->getPath().($includeQuery ? '?'.$this->getQueryString()
            : '');
    }
}
