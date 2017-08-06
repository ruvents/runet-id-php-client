<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use RunetId\ApiClient\Model\Common\Image;
use RunetId\ApiClient\Model\Event\Participation;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class User implements UserRunetIdInterface, RunetIdDenormalizableInterface
{
    use ClassTrait;

    const MALE = 'male';
    const FEMALE = 'female';

    const PHOTO_SMALL = 'Small';
    const PHOTO_MEDIUM = 'Medium';
    const PHOTO_LARGE = 'Large';
    const PHOTO_ORIGINAL = 'Original';

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
     * @var null|string
     */
    protected $phone;

    /**
     * @var null|Participation
     */
    protected $participation;

    /**
     * @var bool
     */
    protected $visible;

    /**
     * @var bool
     */
    protected $verified;

    /**
     * @var null|string
     */
    protected $gender;

    /**
     * @var Work
     */
    protected $work;

    /**
     * @var Image[]
     */
    protected $photos = [];

    /**
     * @var \DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var array
     */
    protected $attributes;

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
     * @return null|string
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
     * @param string $size
     *
     * @return null|Image
     */
    public function getPhoto($size = self::PHOTO_LARGE)
    {
        return isset($this->photos[$size]) ? $this->photos[$size] : null;
    }

    /**
     * @return Image[]
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @return \DateTimeInterface
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
     * @return bool
     */
    public function isMale()
    {
        return self::MALE === $this->gender;
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
        $this->phone = $data['Phone'] ?: null;
        $this->visible = (bool)$data['Visible'];
        $this->verified = (bool)$data['Verified'];

        if ('none' !== $data['Gender']) {
            $this->gender = $data['Gender'];
        }

        $this->createdAt = new \DateTimeImmutable($data['CreationTime']);
        $this->attributes = (array)$data['Attributes'];

        if (isset($data['Work'])) {
            $this->work = $denormalizer
                ->denormalize($data['Work'], Work::className(), $format, array_merge($context, [
                    'parent' => $this,
                ]));
        }

        foreach ($data['Photo'] as $size => $url) {
            $filename = pathinfo($url, PATHINFO_FILENAME);
            $width = null;
            if (false !== $_pos = strrpos($filename, '_')) {
                $width = (int)substr($filename, $_pos + 1);
            }
            $this->photos[$size] = new Image($url, $width, $width);
        }
        /*if (isset($data['Status'])) {
            $this->participation = $denormalizer
                ->denormalize($data['Status'], Participation::className(), $format, array_merge($context, [
                    'parent' => $this,
                ]));
        }*/
    }
}
