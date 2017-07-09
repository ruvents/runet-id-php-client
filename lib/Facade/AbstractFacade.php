<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\User\ExternalIdInterface;
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

    /**
     * @param string|ExternalIdInterface $externalId
     *
     * @return string
     */
    public function toExternalId($externalId)
    {
        return $externalId instanceof ExternalIdInterface ? $externalId->getExternalId() : $externalId;
    }
}
