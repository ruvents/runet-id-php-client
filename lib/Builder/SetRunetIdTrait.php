<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\ArgumentHelper\ArgumentHelper;
use RunetId\ApiClient\ArgumentHelper\UserRunetIdInterface;

trait SetRunetIdTrait
{
    /**
     * @param int|UserRunetIdInterface $runetId
     *
     * @return $this
     */
    public function setRunetId($runetId)
    {
        return $this->setParam('RunetId', ArgumentHelper::getUserRunetId($runetId));
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    abstract protected function setParam($name, $value);
}
