<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Role implements RoleInterface, RunetIdDenormalizableInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $ticketUrl;

    /**
     * @var bool
     */
    protected $registered;

    /**
     * @var \DateTimeInterface
     */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getTicketUrl()
    {
        return $this->ticketUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->id = (int)$data['RoleId'];
        $this->title = $data['RoleTitle'];
        $this->ticketUrl = $data['TicketUrl'];
        $this->registered = (bool)$data['Registered'];
        $this->updatedAt = new \DateTimeImmutable($data['UpdateTime']);
    }
}
