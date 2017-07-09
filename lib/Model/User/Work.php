<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Denormalizer\RunetIdDenormalizableInterface;
use RunetId\ApiClient\Model\Company\Company;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class Work implements RunetIdDenormalizableInterface
{
    /**
     * @var string
     */
    protected $position;

    /**
     * @var Company
     */
    protected $company;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $start;

    /**
     * @var null|\DateTimeImmutable
     */
    protected $end;

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return null|\DateTimeImmutable
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return null|\DateTimeImmutable
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
                'RunetId\ApiClient\Model\Company\Company', $format, $context);
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
