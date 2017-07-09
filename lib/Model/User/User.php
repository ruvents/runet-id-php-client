<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use RunetId\ApiClient\Model\Event\Role;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class User implements RunetIdInterface, RunetIdDenormalizableInterface
{
    const MALE = 'm';
    const FEMALE = 'f';

    /**
     * @var int
     */
    protected $runetId;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $fatherName;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var Role
     */
    protected $eventRole;

    /**
     * @var bool
     */
    protected $visible;

    /**
     * @var bool
     */
    protected $verified;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var Work
     */
    protected $work;

    /**
     * @var Photo
     */
    protected $photo;

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @return int
     */
    public function getRunetId()
    {
        return $this->runetId;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFatherName()
    {
        return $this->fatherName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return Role
     */
    public function getEventRole()
    {
        return $this->eventRole;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @return bool
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return Work
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @return Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->runetId = (int)$data['RunetId'];
        $this->firstName = $data['FirstName'];
        $this->lastName = $data['LastName'];
        $this->fatherName = $data['FatherName'];
        $this->email = $data['Email'];
        $this->phone = $data['Phone'];
        $this->visible = (bool)$data['Visible'];
        $this->verified = (bool)$data['Verified'];
        $this->gender = 'male' === strtolower($data['Gender']) ? self::MALE : self::FEMALE;
        $this->createdAt = new \DateTimeImmutable($data['CreationTime']);
        $this->attributes = (array)$data['Attributes'];

        if (isset($data['Work'])) {
            $this->work = $denormalizer
                ->denormalize($data['Work'], 'RunetId\ApiClient\Model\User\Work', $format, $context);
        }

        if (false === strpos($data['Photo']['Small'], '/files/photo/nophoto')) {
            $this->photo = $denormalizer
                ->denormalize($data['Photo'], 'RunetId\ApiClient\Model\User\Photo', $format, $context);
        }

        if (isset($data['Status'])) {
            $this->eventRole = $denormalizer
                ->denormalize($data['Status'], 'RunetId\ApiClient\Model\Event\Role', $format, $context);
        }
    }
}
