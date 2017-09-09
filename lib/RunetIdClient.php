<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Service\RunetIdService;
use Ruvents\AbstractApiClient\AbstractApiClient;

/**
 * @method Builder\UserAddressBuilder userAddress()
 * @method Builder\UserAuthBuilder userAuth()
 * @method Builder\UserCreateBuilder userCreate()
 * @method Builder\UserGetBuilder userGet()
 */
class RunetIdClient extends AbstractApiClient
{
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
     * @return Builder\AbstractEndpointBuilder
     * @throws \BadMethodCallException
     */
    public function __call($name, array $arguments)
    {
        $class = __NAMESPACE__.'\Builder\\'.ucfirst($name).'Builder';

        return new $class($this);
    }
}
