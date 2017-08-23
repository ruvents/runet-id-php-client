<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\Company\Company;
use RunetId\ApiClient\Model\ModelInterface;

class Work implements ModelInterface
{
    use ClassTrait;

    /**
     * @var null|string
     */
    protected $position;

    /**
     * @var null|Company
     */
    protected $company;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $start;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $end;

    /**
     * @return null|string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return null|Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getEnd()
    {
        return $this->end;
    }
}
