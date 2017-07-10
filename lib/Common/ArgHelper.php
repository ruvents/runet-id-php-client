<?php

namespace RunetId\ApiClient\Common;

use RunetId\ApiClient\Model\Company\CompanyIdInterface;
use RunetId\ApiClient\Model\Event\EventIdInterface;
use RunetId\ApiClient\Model\Event\RoleIdInterface;
use RunetId\ApiClient\Model\User\UserExternalIdInterface;
use RunetId\ApiClient\Model\User\UserRunetIdInterface;

final class ArgHelper
{
    /**
     * @param int|CompanyIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getCompanyId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof CompanyIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement CompanyIdInterface.');
    }

    /**
     * @param int|EventIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getEventId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof EventIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement EventIdInterface.');
    }

    /**
     * @param int|RoleIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getEventRoleId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof RoleIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement RoleIdInterface.');
    }

    /**
     * @param string|UserExternalIdInterface $externalId
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function getUserExternalId($externalId)
    {
        if (is_string($externalId)) {
            return $externalId;
        } elseif ($externalId instanceof UserExternalIdInterface) {
            return $externalId->getExternalId();
        }

        throw new \InvalidArgumentException('Argument must be a string or implement UserExternalIdInterface.');
    }

    /**
     * @param int|UserRunetIdInterface $runetId
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getUserRunetId($runetId)
    {
        if (is_numeric($runetId)) {
            return (int)$runetId;
        } elseif ($runetId instanceof UserRunetIdInterface) {
            return $runetId->getRunetId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement UserRunetIdInterface.');
    }
}
