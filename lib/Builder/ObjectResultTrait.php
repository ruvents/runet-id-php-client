<?php

namespace RunetId\ApiClient\Builder;

trait ObjectResultTrait
{
    /**
     * @see AbstractEndpointBuilder::processResult()
     *
     * @param mixed $result
     *
     * @return null|object
     */
    protected function processResult($result)
    {
        if (null === $result) {
            return null;
        }

        $class = $this->getResultClass();

        if ('[]' === substr($class, -2)) {
            $class = substr($class, 0, -2);

            return array_map(function ($result) use ($class) {
                return new $class($result);
            }, $result);
        }

        return new $class($result);
    }

    /**
     * @return string
     */
    abstract protected function getResultClass();
}
