<?php

namespace RunetId\ApiClient\Model;

use RunetId\ApiClient\Exception\InvalidArgumentException;
use RunetId\ApiClient\Model\User\Photo;
use RunetId\ApiClient\Model\User\Status;
use RunetId\ApiClient\Model\User\Work;

/**
 * Статус участия посетителя на мероприятии
 */
class EventRole
{
    /**
     * Уникальный идентификатор
     *
     * @var int
     */
    public $RoleId;

    /**
     * Название
     *
     * @var string
     */
    public $Name;

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('#%d %s',
            $this->RoleId,
            $this->Name
        );
    }
}
