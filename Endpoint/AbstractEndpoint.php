<?php

namespace RunetId\Client\Endpoint;

use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use RunetId\Client\Result\AbstractResult;
use RunetId\Client\Result\ResultFactory;
use RunetId\Client\RunetIdClient;

/**
 * @internal
 */
abstract class AbstractEndpoint
{
    protected $client;
    protected $method = 'GET';
    private $queryHelper;

    public function __construct(RunetIdClient $client)
    {
        $this->client = $client;
        $this->queryHelper = new QueryHelper();
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return $this
     */
    public function __call($name, array $args)
    {
        if ('set' !== substr($name, 0, 3)) {
            throw new \BadMethodCallException(sprintf('Only setter methods are supported, "%s" called.', $name));
        }

        if (count($args) < 1) {
            throw new \BadMethodCallException('This method requires one argument.');
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
     * @return mixed
     */
    public function getRawResult()
    {
        return $this->client->request($this->createRequest());
    }

    /**
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
     * @return RequestInterface
     */
    protected function createRequest()
    {
        $request = MessageFactoryDiscovery::find()->createRequest($this->method, $this->getEndpoint());

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
