<?php

namespace RunetId\ApiClient\Exception;

/**
 * Class InvalidArgumentException
 * @package RunetId\ApiClient\Exception
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * @param mixed  $var
     * @param string $expectedTypes
     * @return string
     */
    public static function typeMsg($var, $expectedTypes)
    {
        return sprintf(
            'Invalid argument. Must be %s, %s given.',
            $expectedTypes,
            gettype($var)
        );
    }

    /**
     * @param array $haystack
     * @return string
     */
    public static function haystackMsg(array $haystack)
    {
        return sprintf(
            'Invalid argument. Must be one of these: "%s".',
            implode('", "', $haystack)
        );
    }
}
