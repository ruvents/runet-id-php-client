<?php

namespace RunetId\ApiClient\Common;

use RunetId\ApiClient\Model\Company\CompanyIdInterface;
use RunetId\ApiClient\Model\Event\EventIdInterface;
use RunetId\ApiClient\Model\Event\StatusIdInterface;
use RunetId\ApiClient\Model\Pay\ItemIdInterface;
use RunetId\ApiClient\Model\Pay\OrderIdInterface;
use RunetId\ApiClient\Model\Pay\ProductIdInterface;
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
     * @param int|StatusIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getEventStatusId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof StatusIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement StatusIdInterface.');
    }

    /**
     * @param int|ItemIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getPayItemId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof ItemIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement ItemIdInterface.');
    }

    /**
     * @param int|OrderIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getPayOrderId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof OrderIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement OrderIdInterface.');
    }

    /**
     * @param int|ProductIdInterface $id
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function getProductId($id)
    {
        if (is_numeric($id)) {
            return (int)$id;
        } elseif ($id instanceof ProductIdInterface) {
            return $id->getId();
        }

        throw new \InvalidArgumentException('Argument must be numeric or implement ProductIdInterface.');
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
