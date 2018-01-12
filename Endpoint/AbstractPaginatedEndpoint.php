<?php

namespace RunetId\Client\Endpoint;

abstract class AbstractPaginatedEndpoint extends AbstractEndpoint
{
    private $limit = -1;

    /**
     * {@inheritdoc}
     */
    public function getRawResult()
    {
        return $this->client->requestPaginated($this->createRequest(), $this->getOffset(), $this->limit);
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getOffset();
}
