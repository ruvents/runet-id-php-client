<?php

namespace RunetId\ApiClient\Model\Event;

interface RoleInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getTicketUrl();

    /**
     * @return bool
     */
    public function isRegistered();

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt();
}
