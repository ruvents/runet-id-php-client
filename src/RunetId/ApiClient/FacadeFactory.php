<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Facade\UserFacade;
use RunetId\ApiClient\Exception\RuntimeException;

/**
 * Class FacadeFactory
 * @package RunetId\ApiClient
 * @method UserFacade user(int|null $runetId)
 */
class FacadeFactory
{
    /**
     * base facade class name
     */
    const BASE_FACADE = 'RunetId\ApiClient\Facade\BaseFacade';

    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $className = $this->getFacadeClassName($name);

        if (!is_subclass_of($className, self::BASE_FACADE)) {
            throw new RuntimeException(sprintf(
                '%s must extend %s.',
                $className,
                self::BASE_FACADE
            ));
        }

        $facade = new $className($this->apiClient);

        if (method_exists($facade, 'setParams')) {
            call_user_func_array([$facade, 'setParams'], $arguments);
        }

        return $facade;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getFacadeClassName($name)
    {
        return __NAMESPACE__.'\Facade\\'.ucfirst($name).'Facade';
    }
}
