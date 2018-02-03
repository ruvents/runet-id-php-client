<?php

namespace RunetId\Client\HttpClient;

use Http\Message\Authentication;
use Psr\Http\Message\RequestInterface;

final class RunetIdAuthentication implements Authentication
{
    private $key;
    private $secret;

    /**
     * @param string $key
     * @param string $secret
     */
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(RequestInterface $request)
    {
        return $request
            ->withHeader('Apikey', $this->key)
            ->withHeader('Timestamp', $timestamp = time())
            ->withHeader('Hash', substr(md5($this->key.$timestamp.$this->secret), 0, 16));
    }
}
