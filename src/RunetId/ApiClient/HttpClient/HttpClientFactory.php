<?php

namespace RunetId\ApiClient\HttpClient;

use RunetId\ApiClient\App;
use RunetId\ApiClient\Exception\InvalidArgumentException;

/**
 * Class HttpClientFactory
 * @package RunetId\ApiClient\HttpClient
 */
class HttpClientFactory
{
    /**
     * @var App
     */
    protected $app;

    /**
     * @var array
     */
    protected $httpClientsNames = [
        'guzzle' => GuzzleHttpClient::class,
    ];

    /**
     * @var array
     */
    protected $httpClients = [];

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $name
     * @throws InvalidArgumentException
     * @return HttpClientInterface
     */
    public function getHttpClient($name)
    {
        $className = isset($this->httpClientsNames[$name])
            ? $this->httpClientsNames[$name]
            : $name;

        if (!isset($this->httpClients[$className])) {
            $httpClient = new $className($this->app);

            if (!$httpClient instanceof HttpClientInterface) {
                throw new InvalidArgumentException(sprintf(
                    'Invalid argument. Must be "%s" or the name of the class implementing "%s"',
                    implode('", "', array_keys($this->httpClientsNames)),
                    HttpClientInterface::class
                ));
            }

            $this->httpClients[$className] = $httpClient;
        }

        return $this->httpClients[$className];
    }
}
