<?php

namespace RunetId\ApiClient\Result\User;

use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property int         $Id
 * @property null|string $Title
 */
class Professionalinterest extends AbstractResult
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }
}
