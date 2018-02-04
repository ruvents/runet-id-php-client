<?php

namespace RunetId\Client\Helper;

use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\StreamFactory;
use Psr\Http\Message\RequestInterface;

final class FormUrlencodedBodyHelper
{
    private $queryHelper;
    private $streamFactory;

    public function __construct(array $data = [], StreamFactory $streamFactory = null)
    {
        $this->queryHelper = new QueryHelper($data);
        $this->streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->queryHelper->getData();
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->queryHelper->setData($data);

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function addData(array $data)
    {
        $this->queryHelper->addData($data);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function setValue($name, $value)
    {
        $this->queryHelper->setValue($name, $value);

        return $this;
    }

    /**
     * @param RequestInterface $request
     *
     * @return RequestInterface
     */
    public function applyToRequest(RequestInterface $request)
    {
        $body = $this->streamFactory->createStream((string) $this->queryHelper);

        return $request
            ->withBody($body)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
}
