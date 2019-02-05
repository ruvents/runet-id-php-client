<?php

namespace RunetId\Client\Result;

final class ResultFactory
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @param null|array|\Generator $data
     * @param string                $class
     *
     * @throws \UnexpectedValueException
     *
     * @return null|AbstractResult|array|\Generator
     */
    public static function create($data, $class)
    {
        if ('[]' === substr($class, -2)) {
            return self::createCollection($data, substr($class, 0, -2));
        }

        if (null === $data) {
            return null;
        }

        if (!\is_array($data)) {
            throw new \UnexpectedValueException(
                sprintf('Expected null or array, %s given.', \gettype($data))
            );
        }

        return self::createObject($data, $class);
    }

    /**
     * @param array|\Generator $data
     * @param string           $class
     *
     * @throws \UnexpectedValueException
     *
     * @return array|\Generator
     */
    private static function createCollection($data, $class)
    {
        if (\is_array($data)) {
            $result = [];

            foreach ($data as $key => $value) {
                $result[$key] = self::create($value, $class);
            }

            return $result;
        }

        if ($data instanceof \Generator) {
            return self::generateResult($data, $class);
        }

        throw new \UnexpectedValueException(
            sprintf('Expected array or generator, %s given.', \gettype($data))
        );
    }

    /**
     * @param \Generator $data
     * @param string     $class
     *
     * @return \Generator
     */
    private static function generateResult(\Generator $data, $class)
    {
        foreach ($data as $key => $value) {
            yield $key => self::create($value, $class);
        }
    }

    /**
     * @param array  $data
     * @param string $class
     *
     * @throws \UnexpectedValueException
     *
     * @return AbstractResult
     */
    private static function createObject($data, $class)
    {
        if (!class_exists($class)) {
            throw new \UnexpectedValueException(sprintf('Class %s does not exist.', $class));
        }

        if (!is_subclass_of($class, AbstractResult::class)) {
            throw new \UnexpectedValueException(
                sprintf('Result class %s must extend %s.', $class, AbstractResult::class)
            );
        }

        foreach ($class::getMap() as $property => $propertyClass) {
            if (isset($data[$property])) {
                $data[$property] = self::create($data[$property], $propertyClass);
            }
        }

        return new $class($data);
    }
}
