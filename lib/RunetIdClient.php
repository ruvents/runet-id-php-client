<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Facade;
use RunetId\ApiClient\Service\RunetIdService;
use Ruvents\AbstractApiClient\AbstractApiClient;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RunetIdClient extends AbstractApiClient
{
    /**
     * @var array
     */
    protected $facades = [];

    /**
     * @var RunetIdService
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        array $defaultContext = [],
        array $extensions = [],
        RunetIdService $service = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->service = $service ?: new RunetIdService();
        parent::__construct($defaultContext, $extensions, $eventDispatcher);
    }

    /**
     * @return Facade\UserFacade
     */
    public function user()
    {
        return $this->getFacade(Facade\UserFacade::getClass());
    }

    /**
     * @param string $class
     *
     * @return mixed
     */
    protected function getFacade($class)
    {
        if (!isset($this->facades[$class])) {
            $this->facades[$class] = new $class($this);
        }

        return $this->facades[$class];
    }

    /**
     * {@inheritdoc}
     */
    final protected function getService()
    {
        return $this->service;
    }
}
