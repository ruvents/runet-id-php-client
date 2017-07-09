<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\User\RunetIdInterface;
use Ruvents\AbstractApiClient\AbstractApiFacade;

abstract class AbstractFacade extends AbstractApiFacade
{
    /**
     * @param int|RunetIdInterface $runetId
     *
     * @return int
     */
    public function toRunetId($runetId)
    {
        return $runetId instanceof RunetIdInterface ? $runetId->getRunetId() : (int)$runetId;
    }
}
