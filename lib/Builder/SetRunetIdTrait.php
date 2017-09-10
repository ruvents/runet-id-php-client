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
        return $this->setParam('RunetId', ArgHelper::getUserRunetId($runetId));
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    abstract protected function setParam($name, $value);
}
