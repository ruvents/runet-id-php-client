<?php

namespace RunetId\ApiClient\Model\Company;

use RunetId\ApiClient\Common\ClassTrait;
use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Company implements CompanyIdInterface, RunetIdDenormalizableInterface
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
     * {@inheritdoc}
     */
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->id = (int)$data['Id'];
        $this->title = $data['Name'];
    }
}
