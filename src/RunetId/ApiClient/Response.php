<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\InvalidArgumentException;

/**
 * Class Response
 * @package RunetId\ApiClient
 */
class Response
{
    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var int
     */
    private $code;

    /**
     * @param string $body
     * @param array  $headers
     * @param int    $code
     * @throws InvalidArgumentException
     */
    public function __construct($body, array $headers, $code)
    {
        InvalidArgumentException::check($body, '');
        InvalidArgumentException::check($code, 0);

        $this->body = $body;
        $this->headers = $headers;
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @throws InvalidArgumentException
     * @return bool
     */
    public function hasHeader($name)
    {
        InvalidArgumentException::check($name, '');

        return isset($this->headers[$name]);
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getHeader($name)
    {
        if ($this->hasHeader($name)) {
            return $this->headers[$name];
        }

        return null;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }
}
