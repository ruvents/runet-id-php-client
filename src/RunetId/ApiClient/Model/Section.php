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
    //public $Halls;

    /**
     * @var string[]
     */
    public $Places;

    /**
     * @var string[]
     */
    public $Attributes;

    /**
     * @param string $Start
     * @return $this
     */
    public function setStart($Start)
    {
        $this->Start = new \DateTime($Start);

        return $this;
    }

    /**
     * @param string $End
     * @return $this
     */
    public function setEnd($End)
    {
        $this->End = new \DateTime($End);

        return $this;
    }

    /**
     * @param string $UpdateTime
     * @return $this
     */
    public function setUpdateTime($UpdateTime)
    {
        $this->UpdateTime = new \DateTime($UpdateTime);

        return $this;
    }
}
