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
     * @param null|array|\Generator $data
     * @param string                $class
     *
     * @throws ResultFactoryException
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

        if (!is_array($data)) {
            throw ResultFactoryException::createForUnexpectedTypes(['null', 'array'], $data);
        }

        return self::createObject($data, $class);
    }

    /**
     * @param array|\Generator $data
     * @param string           $class
     *
     * @return array|\Generator
     */
    private static function createCollection($data, $class)
    {
        if (is_array($data)) {
            $result = [];

            foreach ($data as $key => $value) {
                $result[$key] = self::create($value, $class);
            }

            return $result;
        }

        if ($data instanceof \Generator) {
            return self::generateResult($data, $class);
        }

        throw ResultFactoryException::createForUnexpectedTypes(['array', \Generator::class], $data);
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
