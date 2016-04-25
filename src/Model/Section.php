<?php

namespace RunetId\ApiClient\Model;

use RunetId\ApiClient\Model\Section\Hall;

/**
 * Class Section
 */
class Section
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
     * @var string
     */
    public $Info;

    /**
     * @var \DateTime
     */
    public $Start;

    /**
     * @var \DateTime
     */
    public $End;

    /**
     * @var \DateTime
     */
    public $UpdateTime;

    /**
     * @var bool
     */
    public $Deleted;

    /**
     * @var string
     */
    public $TypeCode;

    /**
     * @var Hall[]
     */
    public $Halls;

    /**
     * @var string[]
     */
    public $Attributes;

    /**
     * @return string
     */
    public function __toString()
    {
       return (string)$this->Title;
    }
}
