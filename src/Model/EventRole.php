<?php

namespace RunetId\ApiClient\Model;

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
