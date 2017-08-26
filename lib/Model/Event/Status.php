<?php

namespace RunetId\ApiClient\Model\Event;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\PreDenormalizableInterface;
use RunetId\ApiClient\Model\ModelInterface;

class Status implements ModelInterface, StatusIdInterface, PreDenormalizableInterface
{
    use ClassTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|int
     */
    protected $priority;

    /**
     * {@inheritdoc}
     */
    public static function getRunetIdPreDenormalizationMap()
    {
        return [
            'id' => 'RoleId',
            'title' => 'Name',
            'priority' => 'Priority',
        ];
    }

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
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null|int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
