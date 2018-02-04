<?php

namespace RunetId\Client\OAuth;

use Psr\Http\Message\UriInterface;
use RunetId\Client\Endpoint\QueryHelper;

final class OAuthUriGenerator
{
    private $uri;
    private $key;

    /**
     * @param UriInterface $uri
     * @param string       $key
     */
    public function __construct(UriInterface $uri, $key)
    {
        $this->uri = $uri;
        $this->key = $key;
    }

    /**
     * @param string $redirectUrl
     *
     * @return string
     */
    public function generate($redirectUrl)
    {
        return (string) $this->uri
            ->withQuery(QueryHelper::build([
                'apikey' => $this->key,
                'url' => $redirectUrl,
            ]));
    }
}
