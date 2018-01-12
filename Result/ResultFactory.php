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
     * @param array  $data
     * @param string $class
     *
     * @return null|AbstractResult|array
     */
    public static function create(array $data, $class)
    {
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
     * @return AbstractResult
     */
    private static function createObject($data, $class)
    {
        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        if (!is_subclass_of($class, AbstractResult::class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" must extend "%s".', $class, AbstractResult::class));
        }

        foreach ($class::getMap() as $property => $propertyClass) {
            if (isset($data[$property])) {
                $data[$property] = self::create($data[$property], $propertyClass);
            }
        }

        return new $class($data);
    }
}
