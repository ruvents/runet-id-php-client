<?php

namespace RunetId\ApiClient\Model;

/**
 * ProfInterest
 */
class ProfInterest
{
    /**
     * @var int
     */
    public $Id;

    /**
     * @var string
     */
    public $Title;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }
}
