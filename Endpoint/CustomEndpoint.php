<?php

namespace RunetId\Client\Endpoint;

final class CustomEndpoint extends AbstractPostEndpoint
{
    protected $method = 'GET';
    private $endpoint;
    private $class;

    /**
     * @param string $method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param string $endpoint
     *
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException When endpoint was not set
     */
    protected function getEndpoint()
    {
        if (null === $this->endpoint) {
            throw new \RuntimeException('Endpoint was not set. Use setEndpoint().');
        }

        return $this->endpoint;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException When class was not set
     */
    protected function getClass()
    {
        if (null === $this->class) {
            throw new \RuntimeException('Class was not set. Use setClass().');
        }

        return $this->class;
    }
}
