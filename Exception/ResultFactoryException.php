<?php

namespace RunetId\Client\Exception;

final class ResultFactoryException extends \InvalidArgumentException
{
    /**
     * @param string[] $expectedTypes
     * @param mixed    $value
     *
     * @return self
     */
    public static function createForUnexpectedTypes(array $expectedTypes, $value)
    {
        return new self(sprintf(
            'Expected "%s", "%s" given.',
            implode('" or "', $expectedTypes),
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }
}
