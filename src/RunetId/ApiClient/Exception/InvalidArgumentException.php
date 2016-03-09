<?php

namespace RunetId\ApiClient\Exception;

/**
 * Class InvalidArgumentException
 * @package RunetId\ApiClient\Exception
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * @param mixed $variable
     * @param mixed $exampleType
     * @throws self
     */
    public static function check($variable, $exampleType)
    {
        $givenType = gettype($variable);
        $neededType = gettype($exampleType);

        if ($givenType !== $neededType) {
            throw new self(sprintf(
                'Invalid argument. Must be of the type "%s", "%s" given',
                $neededType,
                $givenType
            ));
        }
    }
}
