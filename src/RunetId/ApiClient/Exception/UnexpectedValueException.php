<?php

namespace RunetId\ApiClient\Exception;

/**
 * Class UnexpectedValueException
 * @package RunetId\ApiClient\Exception
 */
class UnexpectedValueException extends \UnexpectedValueException
{
    /**
     * @param mixed $variable
     * @param array $expectedValues
     * @param bool  $strict
     * @throws self
     */
    public static function check($variable, array $expectedValues, $strict = true)
    {
        if (!in_array($variable, $expectedValues, $strict)) {
            throw new self(sprintf(
                'Unexpected value "%s". Must be one of the following: "%s"',
                $variable,
                implode('", "', $expectedValues)
            ));
        }
    }
}

