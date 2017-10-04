<?php

namespace RunetId\ApiClient\ArgumentHelper;

class ArgumentHelper
{
    private function __construct()
    {
    }

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
     * @param int|EventRoleIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getEventRoleId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof EventRoleIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement EventRoleIdInterface.');
    }

    /**
     * @param int|PayItemIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getPayItemId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof PayItemIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement PayItemIdInterface.');
    }

    /**
     * @param int|PayOrderIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getPayOrderId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof PayOrderIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement PayOrderIdInterface.');
    }

    /**
     * @param int|PayProductIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getPayProductId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof PayProductIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement PayProductIdInterface.');
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
