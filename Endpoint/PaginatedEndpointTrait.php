<?php

namespace RunetId\Client\Endpoint;

use Psr\Http\Message\RequestInterface;
use RunetId\Client\RunetIdClient;

/**
 * @property RunetIdClient $client
 *
 * @method $this            setQueryValue(string $name, $value)
 * @method RequestInterface createRequest()
 */
trait PaginatedEndpointTrait
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
