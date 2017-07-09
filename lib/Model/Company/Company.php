<?php

namespace RunetId\ApiClient\Model\Company;

class Company implements CompanyInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    public function __construct(array $data)
    {
        $this->id = (int)$data['Id'];
        $this->name = $data['Name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
