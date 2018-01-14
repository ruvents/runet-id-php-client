<?php

namespace RunetId\Client\Result;

/**
 * @internal
 */
abstract class AbstractResult implements \IteratorAggregate
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param int|string $offset
     *
     * @return bool
     */
    public function __isset($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param int|string $offset
     *
     * @throws \OutOfBoundsException
     *
     * @return mixed
     */
    public function __get($offset)
    {
        if (!$this->exists($offset)) {
            $message = sprintf('Offset "%s" does not exist in the result array.', $offset);

            if ([] === $this->data) {
                $message .= ' The result array is empty.';
            } elseif (1 === count($this->data)) {
                $message .= sprintf(' "%s" offset is available.', key($this->data));
            } else {
                $message .= sprintf(' "%s" offsets are available.', implode('", "', array_keys($this->data)));
            }

            throw new \OutOfBoundsException($message);
        }

        return $this->data[$offset];
    }

    /**
     * @param int|string $offset
     * @param mixed      $value
     *
     * @throws \LogicException
     *
     * @return void
     */
    public function __set($offset, $value)
    {
        throw new \LogicException('Result is immutable.');
    }

    /**
     * @param int|string $offset
     *
     * @throws \LogicException
     *
     * @return void
     */
    public function __unset($offset)
    {
        throw new \LogicException('Result is immutable.');
    }

    /**
     * @return array
     */
    public static function getMap()
    {
        return [];
    }

    /**
     * @param int|string $offset
     *
     * @return bool
     */
    public function exists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}
