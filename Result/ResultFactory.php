<?php

namespace RunetId\Client\Result;

use RunetId\Client\Exception\ResultFactoryException;

final class ResultFactory
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @param null|array $data
     * @param string     $class
     *
     * @throws ResultFactoryException
     *
     * @return null|AbstractResult|array
     */
    public static function create($data, $class)
    {
        if (null === $data) {
            return null;
        }

        if (!is_array($data)) {
            throw new ResultFactoryException(sprintf('Data must be null or an array, %s given.', gettype($data)));
        }

        if ('[]' === substr($class, -2)) {
            $class = substr($class, 0, -2);
            $result = [];

            foreach ($data as $key => $value) {
                $result[$key] = self::create($value, $class);
            }

            return $result;
        }

        return self::createObject($data, $class);
    }

    /**
     * @param array  $data
     * @param string $class
     *
     * @throws ResultFactoryException
     *
     * @return AbstractResult
     */
    private static function createObject($data, $class)
    {
        if (!class_exists($class)) {
            throw new ResultFactoryException(sprintf('Class "%s" does not exist.', $class));
        }

        if (!is_subclass_of($class, AbstractResult::class)) {
            throw new ResultFactoryException(sprintf('Class "%s" must extend "%s".', $class, AbstractResult::class));
        }

        foreach ($class::getMap() as $property => $propertyClass) {
            if (isset($data[$property])) {
                $data[$property] = self::create($data[$property], $propertyClass);
            }
        }

        return new $class($data);
    }
}
