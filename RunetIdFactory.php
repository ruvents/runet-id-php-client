<?php

namespace RunetId\Client;

use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Psr\Http\Message\UriInterface;
use RunetId\Client\HttpClient\RunetIdAuthentication;

final class RunetIdFactory
{
    const DEFAULT_URI = 'http://api.runet-id.com';

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @param string              $key
     * @param string              $secret
     * @param string|UriInterface $defaultUri
     * @param Plugin[]            $plugins
     * @param null|HttpClient     $httpClient
     *
     * @return RunetIdClient
     */
    public static function createClient($key, $secret, $defaultUri = self::DEFAULT_URI, array $plugins = [], HttpClient $httpClient = null)
    {
        $defaultUri = UriFactoryDiscovery::find()->createUri($defaultUri);
        parse_str($defaultUri->getQuery(), $queryDefaults);

        $plugins = array_merge([
            new Plugin\BaseUriPlugin($defaultUri),
            new Plugin\QueryDefaultsPlugin($queryDefaults),
            new Plugin\AuthenticationPlugin(new RunetIdAuthentication($key, $secret)),
            new Plugin\ErrorPlugin(),
        ], $plugins);

        $httpClient = new PluginClient($httpClient ?: HttpClientDiscovery::find(), $plugins);

        return new RunetIdClient($httpClient);
    }
}
