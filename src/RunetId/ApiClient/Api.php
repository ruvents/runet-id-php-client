<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Model\Section;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class Api
 * @package RunetId\ApiClient
 */
class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var array
     */
    protected $classNames = [
        'section' => Section::class,
    ];

    /**
     * @param Client              $client
     * @param SerializerInterface $serializer
     * @param array               $classNames
     */
    public function __construct(Client $client, SerializerInterface $serializer, array $classNames = [])
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->classNames = array_merge($this->classNames, $classNames);
    }

    /**
     * @return Section[]|array
     */
    public function getEventSectionList()
    {
        $response = $this->client->get('event/section/list');

        return $this->deserializeArray($response->getRawBody(), 'section');
    }

    /**
     * @param string $contents
     * @param string $type
     * @return array
     */
    protected function deserializeArray($contents, $type)
    {
        $className = $this->classNames[$type];

        return $this->serializer->deserialize($contents, $className.'[]', 'json');
    }
}
