<?php

namespace RunetId\ApiClient\Api;

use RunetId\ApiClient\Api\Model\Section;
use RunetId\ApiClient\Api\Model\User;
use RunetId\ApiClient\Client;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var array
     */
    protected $classNames = [
        'section' => 'RunetId\ApiClient\Api\Model\Section',
        'user' => 'RunetId\ApiClient\Api\Model\User',
    ];

    /**
     * @param Client              $client
     * @param array               $classNames
     * @param SerializerInterface $serializer
     */
    public function __construct(Client $client, array $classNames = [], SerializerInterface $serializer = null)
    {
        $this->client = $client;
        $this->classNames = array_merge($this->classNames, $classNames);
        $this->serializer = $serializer;
    }

    /**
     * @param $runetId
     * @return User
     */
    public function getUser($runetId)
    {
        $response = $this->client->get('user/get', ['RunetId' => $runetId]);

        return $this->deserializeObject($response->getRawBody(), 'user');
    }

    /**
     * TODO: update Section class
     * @return Section[]
     */
    private function getEventSectionList()
    {
        $response = $this->client->get('event/section/list');

        return $this->deserializeArray($response->getRawBody(), 'section');
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer()
    {
        if (!isset($this->serializer)) {
            $this->serializer = $this->getDefaultSerializer();
        }

        return $this->serializer;
    }

    /**
     * @return Serializer
     */
    public function getDefaultSerializer()
    {
        return new Serializer(
            [new ObjectNormalizer(), new ArrayDenormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @param string $raw
     * @param string $type
     * @return array
     */
    protected function deserializeObject($raw, $type)
    {
        $className = $this->classNames[$type];

        return $this->getSerializer()->deserialize($raw, $className, 'json');
    }

    /**
     * @param string $raw
     * @param string $type
     * @return array
     */
    protected function deserializeArray($raw, $type)
    {
        $className = $this->classNames[$type];

        return $this->getSerializer()->deserialize($raw, $className.'[]', 'json');
    }
}
