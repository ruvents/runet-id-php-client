<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use RunetId\ApiClient\Model\Company\CompanyInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Work implements WorkInterface, RunetIdDenormalizableInterface
{
    /**
     * @var string
     */
    protected $position;

    /**
     * @var CompanyInterface
     */
    protected $company;

    /**
     * @var \DateTimeInterface|null
     */
    protected $start;

    /**
     * @var \DateTimeInterface|null
     */
    protected $end;

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
    public function runetIdDenormalize(DenormalizerInterface $denormalizer, $data, $format = null, array $context = [])
    {
        $this->position = $data['Position'];

        if (isset($data['Company'])) {
            $this->company = $denormalizer->denormalize($data['Company'],
                'RunetId\ApiClient\Model\Company\CompanyInterface', $format, $context);
        }

        if (isset($data['StartYear'])) {
            $start = $data['StartYear'].'-'.(isset($data['StartMonth']) ? $data['StartMonth'] : 1);
            $this->start = new \DateTimeImmutable($start);

            if (isset($data['EndYear'])) {
                $end = $data['EndYear'].'-'.(isset($data['EndMonth']) ? $data['EndMonth'] : 1);
                $this->end = new \DateTimeImmutable($end);
            }
        }
    }
}
