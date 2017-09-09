<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\RunetIdClient;

abstract class AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [];

    /**
     * @var RunetIdClient
     */
    private $client;

    final public function __construct(RunetIdClient $client)
    {
        $this->client = $client;
    }

    final public function __call($name, array $args)
    {
        if ('set' !== substr($name, 0, 3)) {
            throw new \BadMethodCallException('Only setter methods are supported.');
        }

        if (1 > count($args)) {
            throw new \BadMethodCallException('This method requires one argument.');
        }

        $this->setParam(substr($name, 3), $args[0]);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    final public function setQueryParam($name, $value)
    {
        $this->context['query'][$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    final public function setParam($name, $value)
    {
        $this->context['data'][$name] = $value;

        return $this;
    }

    /**
     * @param int $eventId
     *
     * @return $this
     */
    final public function setEventId($eventId)
    {
        $this->context['event_id'] = $eventId;

        return $this;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    final public function setLanguage($language)
    {
        $this->context['language'] = $language;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        $result = $this->client->request($this->context);

        if (null !== $class = $this->getResultClass() && null !== $result) {
            $result = new $class($result);
        }

        return $result;
    }

    /**
     * @return null|string
     */
    protected function getResultClass()
    {
        return null;
    }
}
