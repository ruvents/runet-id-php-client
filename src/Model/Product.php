<?php

namespace RunetId\ApiClient\Model;

/**
 * Class Product
 */
class Product
{
    /**
     * @var int
     */
    public $Id;

    /**
     * @var string
     */
    public $Manager;

    /**
     * @var string
     */
    public $Title;

    /**
     * @var int
     */
    public $Price;

    /**
     * @var array
     */
    public $Attributes;

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->Title;
    }
}
