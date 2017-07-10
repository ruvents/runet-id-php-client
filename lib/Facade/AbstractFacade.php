<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\User\ExternalIdInterface;
use RunetId\ApiClient\Model\User\RunetIdInterface;
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
     * @param array  $params
     *
     * @return mixed
     */
    protected function requestGet(array $context, $endpoint, array $params = [])
    {
        return $this->client->request(array_replace_recursive($context, [
            'endpoint' => $endpoint,
            'get_data' => $params,
            'method' => 'GET',
        ]));
    }

    /**
     * @param array  $context
     * @param string $endpoint
     * @param array  $params
     *
     * @return mixed
     */
    protected function requestPost(array $context, $endpoint, array $params = [])
    {
        return $this->client->request(array_replace_recursive($context, [
            'endpoint' => $endpoint,
            'post_data' => $params,
            'method' => 'POST',
        ]));
    }

    /**
     * @param int|RunetIdInterface $runetId
     *
     * @return int
     */
    protected function toRunetId($runetId)
    {
        return $runetId instanceof RunetIdInterface ? $runetId->getRunetId() : (int)$runetId;
    }

    /**
     * @param string|ExternalIdInterface $externalId
     *
     * @return string
     */
    protected function toExternalId($externalId)
    {
        return $externalId instanceof ExternalIdInterface ? $externalId->getExternalId() : $externalId;
    }
}
