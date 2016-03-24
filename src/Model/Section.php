<?php

namespace RunetId\ApiClient\Model;

/**
 * Class Section
 * @package RunetId\ApiClient\Model
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
    public $Type;

    /**
     * @var string
     */
    public $TypeCode;

    /**
     * @var string[]
     */
    public $Halls;

    /**
     * @var string[]
     */
    public $Places;

    /**
     * @var string[]
     */
    public $Attributes;
}
