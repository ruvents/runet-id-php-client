<?php

namespace RunetId\Client\OAuth;

use Psr\Http\Message\UriInterface;
use RunetId\Client\Endpoint\QueryHelper;

final class OAuthUriGenerator
{
    private $uri;
    private $queryHelper;

    /**
     * @param UriInterface $uri
     * @param string       $key
     */
    public function __construct(UriInterface $uri, $key)
    {
        $this->uri = $uri;
        $this->queryHelper = (new QueryHelper($uri->getQuery()))
            ->setValue('apikey', $key);
    }

    /**
     * @param string $redirectUrl
     *
     * @return string
     */
    public function generate($redirectUrl)
    {
        return (string) $this->queryHelper
            ->setValue('url', $redirectUrl)
            ->applyToUri($this->uri);
    }
}
