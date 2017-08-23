<?php

namespace RunetId\ApiClient\Model\Company;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\ModelInterface;

class Company implements ModelInterface, CompanyIdInterface
{
    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $title;

    public function __toString()
    {
        return (string)$this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
