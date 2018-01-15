<?php

namespace RunetId\Client\Endpoint;

use Http\Discovery\Exception\NotFoundException;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
use Psr\Http\Message\RequestInterface;
use RunetId\Client\Exception\JsonDecodeException;
use RunetId\Client\Exception\ResultFactoryException;
use RunetId\Client\Exception\RunetIdException;
use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\ResultFactory;
use RunetId\Client\RunetIdClient;

/**
 * @internal
 */
abstract class AbstractEndpoint
{
    protected $client;
    protected $requestFactory;
    protected $streamFactory;
    protected $method = 'GET';
    private $queryHelper;

    public function __construct(RunetIdClient $client, RequestFactory $requestFactory = null, StreamFactory $streamFactory = null)
    {
        $this->client = $client;
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        $this->streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();
        $this->queryHelper = new QueryHelper();
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @throws \BadMethodCallException
     *
     * @return $this
     */
    public function __call($name, array $args)
    {
        if ('set' !== substr($name, 0, 3)) {
            throw new \BadMethodCallException(sprintf('Only setter methods are supported, "%s" called.', $name));
        }

        if (count($args) < 1) {
            throw new \BadMethodCallException(sprintf('Method %s::%s() requires one argument.', static::class, $name));
        }

        $this->applyMagicSetter(substr($name, 3), $args[0]);

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setQueryData(array $data)
    {
        $this->queryHelper->setData($data);

        return $this;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function addQueryData(array $data)
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
    public function setQueryValue($name, $value)
    {
        $this->queryHelper->setValue($name, $value);

        return $this;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        return $this->setQueryValue('Language', $language);
    }

    /**
     * @param int $maxResults
     *
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        return $this->setQueryValue('MaxResults', $maxResults);
    }

    /**
     * @throws \Http\Client\Exception When an error happens during processing the request
     * @throws JsonDecodeException    When json_decode fails
     * @throws RunetIdException       When RUNET-ID API returns an error
     *
     * @return mixed
     */
    public function getRawResult()
    {
        return $this->client->request($this->createRequest());
    }

    /**
     * @throws \Http\Client\Exception When an error happens during processing the request
     * @throws JsonDecodeException    When json_decode fails
     * @throws RunetIdException       When RUNET-ID API returns an error
     * @throws ResultFactoryException When ResultFactory fails to create an object
     *
     * @return null|AbstractResult|array
     */
    public function getResult()
    {
        return ResultFactory::create($this->getRawResult(), $this->getClass());
    }

    /**
     * @return string
     */
    abstract protected function getEndpoint();

    /**
     * @return string
     */
    abstract protected function getClass();

    /**
     * @throws NotFoundException When Discovery fails to find a message factory
     *
     * @return RequestInterface
     */
    protected function createRequest()
    {
        $request = $this->requestFactory->createRequest($this->method, $this->getEndpoint());

        return $this->queryHelper->apply($request);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    protected function applyMagicSetter($name, $value)
    {
        $this->queryHelper->setValue($name, $value);
    }
}
