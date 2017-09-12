<?php

namespace RunetId\ApiClient\Result\Event;

use RunetId\ApiClient\Result\AbstractResult;

/**
 * @property int         $RoleId
 * @property null|string $Name
 * @property null|int    $Priority
 */
class Role extends AbstractResult implements RoleIdInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->RoleId;
    }
}
