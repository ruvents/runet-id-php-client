<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\PreDenormalizableInterface;
use RunetId\ApiClient\Model\Event\Participation;
use RunetId\ApiClient\Model\ModelInterface;

class User implements ModelInterface, UserRunetIdInterface, PreDenormalizableInterface
{
    use ClassTrait;

    const MALE = 'male';
    const FEMALE = 'female';

    /**
     * @var int
     */
    protected $runetId;

    /**
     * @var null|string
     */
    protected $firstName;

    /**
     * @var null|string
     */
    protected $lastName;

    /**
     * @var null|string
     */
    protected $fatherName;

    /**
     * @var null|string
     */
    protected $email;

    /**
     * @var null|string
     */
    protected $phone;

    /**
     * @var null|Participation
     */
    protected $participation;

    /**
     * @var null|bool
     */
    protected $visible;

    /**
     * @var null|bool
     */
    protected $verified;

    /**
     * @var null|string
     */
    protected $gender;

    /**
     * @var null|Work
     */
    protected $work;

    /**
     * @var null|string
     */
    protected $photo;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var null|array
     */
    protected $attributes;

    /**
     * @return string
     */
    public function __toString()
    {
        return trim($this->firstName.' '.$this->lastName);
    }

    /**
     * @return int
     */
    public function getRunetId()
    {
        return $this->runetId;
    }

    /**
     * @return null|string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return null|string
     */
    public function getFatherName()
    {
        return $this->fatherName;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return null|string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return null|Participation
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * @return null|bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @return null|bool
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @return null|string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return null|Work
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @return null|string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return null|array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return bool
     */
    public function isMale()
    {
        return self::MALE === $this->gender;
    }

    /**
     * {@inheritdoc}
     */
    public static function getRunetIdPreDenormalizationMap()
    {
        return [
            'runetId' => 'RunetId',
            'firstName' => 'FirstName',
            'lastName' => 'LastName',
            'fatherName' => 'FatherName',
            'email' => 'Email',
            'phone' => 'Phone',
            'visible' => 'Visible',
            'gender' => function (array $raw, &$exists) {
                if ($exists = array_key_exists('Gender', $raw)) {
                    return 'none' === $raw['Gender'] ? null : $raw['Gender'];
                }

                return null;
            },
            'verified' => 'Verified',
            'createdAt' => 'CreationTime',
            'attributes' => 'Attributes',
            'work' => 'Work',
            'participation' => 'Status',
            'photo' => function (array $raw, &$exists) {
                if ($exists = isset($raw['Photo']['Original'])) {
                    return $raw['Photo']['Original'];
                }

                return null;
            },
        ];
    }
}
