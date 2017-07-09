<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Model\Event\RoleInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class User implements UserInterface, DenormalizableInterface
{
    /**
     * @var int
     */
    private $runetId;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $fatherName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var RoleInterface
     */
    private $eventRole;

    /**
     * @var bool
     */
    private $visible;

    /**
     * @var bool
     */
    private $verified;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var WorkInterface
     */
    private $work;

    /**
     * @var PhotoInterface
     */
    private $photo;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @var array
     */
    private $attributes;

    /**
     * {@inheritdoc}
     */
    public function getRunetId()
    {
        return $this->runetId;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFatherName()
    {
        return $this->fatherName;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventRole()
    {
        return $this->eventRole;
    }

    /**
     * {@inheritdoc}
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * {@inheritdoc}
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * {@inheritdoc}
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * {@inheritdoc}
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->runetId = (int)$data['RunetId'];
        $this->firstName = $data['FirstName'];
        $this->lastName = $data['LastName'];
        $this->fatherName = $data['FatherName'];
        $this->email = $data['Email'];
        $this->phone = $data['Phone'];
        $this->visible = (bool)$data['Visible'];
        $this->verified = (bool)$data['Verified'];
        $this->gender = 'male' === strtolower($data['Gender'])
            ? UserInterface::MALE
            : UserInterface::FEMALE;
        $this->createdAt = new \DateTimeImmutable($data['CreationTime']);
        $this->attributes = (array)$data['Attributes'];

        if (isset($data['Work'])) {
            $this->work = $denormalizer
                ->denormalize($data['Work'], 'RunetId\ApiClient\Model\User\WorkInterface', $format, $context);
        }

        if (false === strpos($data['Photo']['Small'], '/files/photo/nophoto')) {
            $this->photo = $denormalizer
                ->denormalize($data['Photo'], 'RunetId\ApiClient\Model\User\PhotoInterface', $format, $context);
        }

        if (isset($data['Status'])) {
            $this->eventRole = $denormalizer
                ->denormalize($data['Status'], 'RunetId\ApiClient\Model\Event\RoleInterface', $format, $context);
        }
    }
}