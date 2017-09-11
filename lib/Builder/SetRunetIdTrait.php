<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Result\User\UserRunetIdInterface;

/**
 * @property array $context
 */
trait SetRunetIdTrait
{
    /**
     * @param int|UserRunetIdInterface $runetId
     *
     * @return $this
     */
    public function setRunetId($runetId)
    {
        $this->context['query']['RunetId'] = ArgHelper::getUserRunetId($runetId);

        return $this;
    }
}
