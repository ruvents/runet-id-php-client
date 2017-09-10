<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Result\User\UserRunetIdInterface;

trait SetRunetIdTrait
{
    /**
     * @param int|UserRunetIdInterface $runetId
     *
     * @return $this
     */
    public function setRunetId($runetId)
    {
        return $this->setQueryParam('RunetId', ArgHelper::getUserRunetId($runetId));
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    abstract public function setQueryParam($name, $value);
}
