<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Model\ModelInterface;

class Participation implements ModelInterface
{
    use ClassTrait;

    /**
     * @var null|Status
     */
    protected $status;

    /**
     * @var null|string
     */
    protected $ticketUrl;

    /**
     * @var null|bool
     */
    protected $registered;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $updatedAt;

    /**
     * @return null|Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return null|string
     */
    public function getTicketUrl()
    {
        return $this->ticketUrl;
    }

    /**
     * @return null|bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
