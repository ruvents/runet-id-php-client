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
            $class = $this->getResultClass();
            $result = new $class($result);
        }

        return $result;
    }

    /**
     * @return string
     */
    abstract protected function getResultClass();
}
