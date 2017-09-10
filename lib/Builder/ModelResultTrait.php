<?php

namespace RunetId\ApiClient\Builder;

trait ModelResultTrait
{
    /**
     * @see AbstractEndpointBuilder::denormalizeResult()
     *
     * @param mixed $result
     *
     * @return null|object
     */
    public function denormalizeResult($result)
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
