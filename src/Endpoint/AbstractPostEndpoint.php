<?php

namespace RunetId\Client\Endpoint;

use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
use RunetId\Client\RunetIdClient;

abstract class AbstractPostEndpoint extends AbstractEndpoint
{
    protected $method = 'POST';
    private $bodyHelper;

    public function __construct(RunetIdClient $client, RequestFactory $requestFactory = null, StreamFactory $streamFactory = null)
    {
        parent::__construct($client, $requestFactory, $streamFactory);
        $this->bodyHelper = new FormUrlencodedBodyHelper([], $streamFactory);
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
        $request = parent::createRequest();

        if (in_array(strtoupper($this->method), ['POST', 'PUT', 'PATCH'], true)) {
            $request = $this->bodyHelper->applyToRequest($request);
        }

        return $request;
    }

    /**
     * {@inheritdoc}
     */
    protected function applyMagicSetter($name, $value)
    {
        $this->bodyHelper->setValue($name, $value);
    }
}
