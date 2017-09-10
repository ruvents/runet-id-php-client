<?php

namespace RunetId\ApiClient\Model;

abstract class AbstractModel
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $denormalizedData = [];

    /**
     * @param array $data
     */
    final public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    final public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    final public function __isset($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param string $offset
     *
     * @return mixed
     */
    final public function __get($offset)
    {
        if (!array_key_exists($offset, $this->denormalizedData)) {
            $value = $this->data[$offset];

            if (isset($this->getMap()[$offset]) && null !== $value) {
                $class = $this->getMap()[$offset];
                $value = new $class($value);
            }

            $this->denormalizedData[$offset] = $value;
        }

        return $this->denormalizedData[$offset];
    }

    /**
     * @param string $offset
     * @param mixed  $value
     *
     * @throws \LogicException
     */
    final public function __set($offset, $value)
    {
        throw new \LogicException('This object is immutable.');
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    final public function exists($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @return string[]
     */
    protected function getMap()
    {
        return [];
    }
}
