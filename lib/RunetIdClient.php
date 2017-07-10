<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Facade;
use RunetId\ApiClient\Service\RunetIdService;
use Ruvents\AbstractApiClient\AbstractApiClient;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @method Facade\UserFacade user()
 */
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
     * @param string $name
     * @param array  $arguments
     *
     * @return Facade\AbstractFacade
     */
    public function __call($name, array $arguments = [])
    {
        $class = __NAMESPACE__.'\\Facade\\'.ucfirst($name).'Facade';

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
