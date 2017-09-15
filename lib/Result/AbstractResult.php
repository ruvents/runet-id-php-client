<?php

namespace RunetId\ApiClient\Result;

abstract class AbstractResult
{
    /**
     * @var array
     */
    private $result;

    /**
     * @var string[]
     */
    private $map;

    /**
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
        $this->map = $this->getMap();
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function __isset($offset)
    {
        return isset($this->result[$offset]);
    }

    /**
     * @param string $offset
     *
     * @return mixed
     */
    public function __get($offset)
    {
        if (!isset($this->result[$offset])) {
            return null;
        }

        if (isset($this->map[$offset])) {
            $this->result[$offset] = ResultDenormalizer::denormalize($this->result[$offset], $this->map[$offset]);

            unset($this->map[$offset]);
        }

        return $this->result[$offset];
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
     * @return string[]
     */
    protected function getMap()
    {
        return [];
    }
}
