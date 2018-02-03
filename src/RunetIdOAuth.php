<?php

namespace RunetId\Client;

final class RunetIdOAuth
{
    const DEFAULT_HOST = 'https://runet-id.com';

    /**
     * @param string $key
     * @param string $redirectUrl
     * @param string $host
     *
     * @return string
     */
    public static function getUrl($key, $redirectUrl, $host = self::DEFAULT_HOST)
    {
        $query = [
            'apikey' => $key,
            'url' => $redirectUrl,
        ];

        return rtrim($host, '/').'/oauth/main/dialog?'.http_build_query($query, '', '&');
    }
}
