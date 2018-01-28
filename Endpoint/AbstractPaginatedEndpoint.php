<?php

namespace RunetId\Client\Endpoint;

abstract class AbstractPaginatedEndpoint extends AbstractEndpoint
{
    /**
     * @param null|int $maxResults
     *
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        return $this->setQueryValue('MaxResults', $maxResults);
    }

    /**
     * {@inheritdoc}
     */
    public function getRawResult()
    {
        return $this->client->requestPaginated($this->createRequest(), $this->getItemsKey());
    }

    /**
     * @return string
     */
    abstract protected function getItemsKey();
}
