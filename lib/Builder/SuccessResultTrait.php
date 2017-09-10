<?php

namespace RunetId\ApiClient\Builder;

trait SuccessResultTrait
{
    /**
     * @see AbstractEndpointBuilder::denormalizeResult()
     *
     * @param mixed $result
     *
     * @return bool
     */
    public function denormalizeResult($result)
    {
        return is_array($result) && isset($result['Success']) && true === $result['Success'];
    }
}
