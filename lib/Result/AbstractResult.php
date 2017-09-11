<?php

namespace RunetId\ApiClient\Result;

abstract class AbstractResult
{
    /**
     * @var array
     */
    private $result;

    /**
     * @var array
     */
    private $processedResult = [];

    /**
     * @param array $result
     */
    final public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * @param string $class
     * @param mixed  $data
     *
     * @return null|object|object[]
     */
    final public static function create($class, $data)
    {
        if ('[]' === substr($class, -2)) {
            $class = substr($class, 0, -2);

            return array_map(function ($data) use ($class) {
                return self::create($class, $data);
            }, $data);
        } elseif (null === $data) {
            return null;
        }

        return new $class($data);
    }

    /**
     * @return array
     */
    final public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    final public function __isset($offset)
    {
        return isset($this->result[$offset]);
    }

    /**
     * @param string $offset
     *
     * @return mixed
     */
    final public function __get($offset)
    {
        if (!array_key_exists($offset, $this->processedResult)) {
            $value = $this->result[$offset];
            $map = $this->getMap();

            if (isset($map[$offset])) {
                $value = self::create($map[$offset], $value);
            }

            $this->processedResult[$offset] = $value;
        }

        return $this->processedResult[$offset];
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
        return array_key_exists($key, $this->result);
    }

    /**
     * @return string[]
     */
    protected function getMap()
    {
        return [];
    }
}
