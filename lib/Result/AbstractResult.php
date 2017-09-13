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
    final public function __construct(array $result)
    {
        $this->result = $result;
        $this->map = $this->getMap();
    }

    /**
     * @param string $class
     * @param mixed  $data
     *
     * @return null|array|object
     */
    final public static function create($class, $data)
    {
        if ('[]' === substr($class, -2)) {
            $class = substr($class, 0, -2);

            return array_map(function ($data) use ($class) {
                return self::create($class, $data);
            }, $data);
        }

        if (null === $data) {
            return null;
        }

        return new $class($data);
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
        if (!$this->__isset($offset)) {
            return null;
        }

        if (isset($this->map[$offset])) {
            $this->result[$offset] = self::create($this->map[$offset], $this->result[$offset]);
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
