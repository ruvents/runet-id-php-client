<?php

namespace RunetId\Client\Endpoint;

use Psr\Http\Message\RequestInterface;

final class QueryHelper
{
    private $data = [];

    /**
     * @param array|string $data
     */
    public function __construct($data = [])
    {
        if (is_string($data)) {
            parse_str($data, $data);
        }

        $this->data = $data;
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
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
    public function apply(RequestInterface $request)
    {
        $uri = $request->getUri();
        parse_str($uri->getQuery(), $oldQueryData);
        $query = http_build_query(array_replace($oldQueryData, $this->data), null, '&');

        return $request->withUri($uri->withQuery($query));
    }
}
