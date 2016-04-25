<?php

namespace RunetId\ApiClient\Model;

/**
 * Class ProfInterest
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
