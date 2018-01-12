<?php

namespace RunetId\Client\Endpoint;

use RunetId\Client\RunetIdClient;

abstract class AbstractPostEndpoint extends AbstractEndpoint
{
    protected $method = 'POST';
    private $bodyHelper;

    public function __construct(RunetIdClient $client)
    {
        parent::__construct($client);
        $this->bodyHelper = new FormUrlencodedBodyHelper();
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setFormData(array $data)
    {
        $this->bodyHelper->setData($data);

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function addFormData(array $data)
    {
        $this->bodyHelper->addData($data);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setFormValue($name, $value)
    {
        $this->bodyHelper->setValue($name, $value);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function createRequest()
    {
        return $this->bodyHelper->apply(parent::createRequest());
    }

    /**
     * {@inheritdoc}
     */
    protected function applyMagicSetter($name, $value)
    {
        $this->bodyHelper->setValue($name, $value);
    }
}
