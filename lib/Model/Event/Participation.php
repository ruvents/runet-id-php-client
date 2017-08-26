<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\PreDenormalizableInterface;
use RunetId\ApiClient\Model\ModelInterface;

class Participation implements ModelInterface, PreDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var Status
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
     * {@inheritdoc}
     */
    public static function getRunetIdPreDenormalizationMap()
    {
        return [
            'ticketUrl' => 'TicketUrl',
            'registered' => 'Registered',
            'updatedAt' => 'UpdateTime',
            'status' => function (array $raw, &$exists) {
                if ($exists = isset($raw['RoleId']) && isset($raw['RoleName'])) {
                    return [
                        'RoleId' => $raw['RoleId'],
                        'Name' => $raw['RoleName'],
                    ];
                }

                return null;
            },
        ];
    }

    /**
     * @return Status
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
    public function getRegistered()
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
