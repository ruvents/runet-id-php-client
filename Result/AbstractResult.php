<?php

namespace RunetId\Client\Result;

/**
 * @internal
 */
abstract class AbstractResult
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $offset
     *
     * @return null|mixed
     */
    public function __get($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function __isset($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @return array
     */
    public static function getMap()
    {
        return [];
    }

    /**
     * @param string $offset
     *
     * @return bool
     */
    public function exists($offset)
    {
        return array_key_exists($offset, $this->data);
    }
}
