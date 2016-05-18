<?php

namespace RunetId\ApiClient\Model\Section;

/**
 * Section hall
 */
class Hall
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
     * @var \DateTime
     */
    public $UpdateTime;

    /**
     * @var int
     */
    public $Order;

    /**
     * @var bool
     */
    public $Deleted;

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }
}
