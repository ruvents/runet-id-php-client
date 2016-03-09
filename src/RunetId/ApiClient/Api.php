<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\UnexpectedValueException;
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
     * @var App
     */
    protected $app;

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
     * @param App                 $app
     * @param SerializerInterface $serializer
     * @param array               $classNames
     */
    public function __construct(App $app, SerializerInterface $serializer, array $classNames = [])
    {
        $this->app = $app;
        $this->serializer = $serializer;
        $this->classNames = array_merge($this->classNames, $classNames);
    }

    /**
     * @return Section[]|array
     */
    public function getEventSectionList()
    {
        $response = $this->app->get('event/section/list');

        return $this->deserializeArray($response, 'section');
    }

    /**
     * @param Response $response
     * @param string   $type
     * @throws UnexpectedValueException
     * @return array
     */
    protected function deserializeArray(Response $response, $type)
    {
        UnexpectedValueException::check($type, array_keys($this->classNames));

        $className = $this->classNames[$type];

        return $this->serializer->deserialize($response->getBody(), $className.'[]', 'json');
    }
}
