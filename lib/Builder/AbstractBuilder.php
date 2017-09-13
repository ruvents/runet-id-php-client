<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\RunetIdClient;

abstract class AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [];

    /**
     * @var RunetIdClient
     */
    private $client;

    public function __construct(RunetIdClient $client)
    {
        $this->client = $client;
    }

    final public function __call($name, array $args)
    {
        if ('set' !== substr($name, 0, 3)) {
            throw new \BadMethodCallException('Only setter methods are supported.');
        }

        if (count($args) < 1) {
            throw new \BadMethodCallException('This method requires one argument.');
        }

        return $this->setParam(substr($name, 3), $args[0]);
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
     * @param array $params
     *
     * @return $this
     */
    final public function setParams(array $params)
    {
        $this->context['data'] = array_replace($this->context['data'], $params);

        return $this;
    }

    /**
     * @param null|int $eventId
     *
     * @return $this
     */
    final public function setEventId($eventId = null)
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
        return $this->client->request($this->context);
    }
}
