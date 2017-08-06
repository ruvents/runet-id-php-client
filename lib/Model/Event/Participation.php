<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Participation implements RunetIdDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var Role
     */
    protected $role;

    /**
     * @var string
     */
    protected $ticketUrl;

    /**
     * @var bool
     */
    protected $registered;

    /**
     * @var \DateTimeImmutable
     */
    protected $updatedAt;

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getTicketUrl()
    {
        return $this->ticketUrl;
    }

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return $this->registered;
    }

    /**
     * @return \DateTimeInterface
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
        $this->ticketUrl = $data['TicketUrl'];
        $this->registered = (bool)$data['Registered'];
        $this->updatedAt = new \DateTimeImmutable($data['UpdateTime']);
        $this->role = $denormalizer
            ->denormalize($data['Role'], Role::className(), $format, array_merge($context, [
                'parent' => $this,
            ]));
    }
}
