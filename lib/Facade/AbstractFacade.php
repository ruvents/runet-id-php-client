<?php

namespace RunetId\ApiClient\Facade;

use Psr\Http\Message\StreamInterface;
use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\RunetIdClient;

abstract class AbstractFacade
{
    use ClassTrait;

    /**
     * @var RunetIdClient
     */
    protected $client;

    public function __construct(RunetIdClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param array  $context
     * @param string $endpoint
     * @param array  $query
     *
     * @return mixed
     */
    protected function requestGet(array $context, $endpoint, array $query = [])
    {
        $context = array_replace([
            'method' => 'GET',
            'endpoint' => $endpoint,
            'query' => [],
        ], $context);

        $context['query'] = array_replace($query, $context['query']);

        return $this->client->request($context);
    }

    /**
     * @param array                        $context
     * @param string                       $endpoint
     * @param string|array|StreamInterface $body
     *
     * @return mixed
     */
    protected function requestPost(array $context, $endpoint, $body)
    {
        return $this->client->request(array_replace($context, [
            'body' => $body,
            'endpoint' => $endpoint,
            'method' => 'POST',
        ]));
    }
}
