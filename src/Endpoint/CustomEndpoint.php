<?php

namespace RunetId\Client\Endpoint;

final class CustomEndpoint extends AbstractPostEndpoint
{
    use PaginatedEndpointTrait {
        getRawResult as getRawPaginatedResult;
    }

    protected $method = 'GET';
    private $endpoint;
    private $class;
    private $paginated = false;
    private $itemsKey;

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
     * @param bool $paginated
     *
     * @return $this
     */
    public function setPaginated($paginated = true)
    {
        $this->paginated = $paginated;

        return $this;
    }

    /**
     * @param string $itemsKey
     *
     * @return $this
     */
    public function setItemsKey($itemsKey)
    {
        $this->itemsKey = $itemsKey;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRawResult()
    {
        if ($this->paginated) {
            return $this->getRawPaginatedResult();
        }

        return parent::getRawResult();
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

    /**
     * {@inheritdoc}
     */
    protected function getItemsKey()
    {
        if (null === $this->itemsKey) {
            throw new \RuntimeException('Paginated items key was not set. Use setItemsKey().');
        }

        return $this->itemsKey;
    }
}
