<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Role implements RoleIdInterface, RunetIdDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $priority;

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->id = (int)$data['RoleId'];
        $this->title = $data['Name'];
        $this->priority = (int)$data['Priority'];
    }
}
