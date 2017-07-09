<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Model\Company\CompanyInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Work implements WorkInterface, DenormalizableInterface
{
    /**
     * @var string
     */
    private $position;

    /**
     * @var CompanyInterface
     */
    private $company;

    /**
     * @var \DateTimeInterface|null
     */
    private $start;

    /**
     * @var \DateTimeInterface|null
     */
    private $end;

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * {@inheritdoc}
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = array())
    {
        $this->position = $data['Position'];

        if (isset($data['Company'])) {
            $this->company = $denormalizer->denormalize($data['Company'],
                'RunetId\ApiClient\Model\Company\CompanyInterface', $format, $context);
        }
        // todo: start, end
    }
}
