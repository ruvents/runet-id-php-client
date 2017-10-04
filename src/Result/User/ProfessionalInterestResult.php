<?php

namespace RunetId\ApiClient\Result\User;

use Ruvents\AbstractApiClient\Result\AbstractResult;

/**
 * @property int         $Id
 * @property null|string $Title
 */
class ProfessionalInterestResult extends AbstractResult
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }
}
