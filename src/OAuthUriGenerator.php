<?php

namespace RunetId\Client;

use Psr\Http\Message\UriInterface;
use RunetId\Client\Helper\QueryHelper;

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
        $this->queryHelper = new QueryHelper(['apikey' => $key]);
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
