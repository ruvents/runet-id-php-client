<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Facade;
use RunetId\ApiClient\Service\RunetIdService;
use Ruvents\AbstractApiClient\AbstractApiClient;

/**
 * @method Facade\EventFacade event()
 * @method Facade\UserFacade user()
 */
class RunetIdClient extends AbstractApiClient
{
    /**
     * @var array
     */
    protected $facades = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $defaultContext = [], array $extensions = [], RunetIdService $service = null)
    {
        parent::__construct($service ?: new RunetIdService(), $defaultContext, $extensions);
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
}
