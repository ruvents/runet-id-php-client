<?php

namespace RunetId\Client\Helper;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

final class QueryHelper
{
    private $data = [];

    /**
     * @param array|string $data
     */
    public function __construct($data = [])
    {
        if (is_string($data)) {
            $data = self::parse($data);
        }

        $this->data = $data;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return self::build($this->data);
    }

    /**
     * @param string $query
     *
     * @return array
     */
    public static function parse($query)
    {
        parse_str($query, $data);

        return $data;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public static function build(array $data)
    {
        return http_build_query($data, '', '&');
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getValue($name, $default = null)
    {
        return isset($this->data[$name]) ? $this->data[$name] : $default;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function addData(array $data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setValue($name, $value)
    {
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * @param UriInterface $uri
     *
     * @return UriInterface
     */
    public function applyToUri(UriInterface $uri)
    {
        $query = array_replace(self::parse($uri->getQuery()), $this->data);

        return $uri->withQuery(self::build($query));
    }

    /**
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
    public function applyToRequest(RequestInterface $request)
    {
        return $request->withUri($this->applyToUri($request->getUri()));
    }
}
