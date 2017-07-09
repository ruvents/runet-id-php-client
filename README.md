# Официальный API клиент RUNET ID для PHP

## Установка

### php >=5.5

`$ composer require guzzlehttp/psr7 php-http/guzzle6-adapter runet-id/api-client:^3.0@alpha`

### php 5.4

```json
{
    "require": {
        "guzzlehttp/psr7": "^1.0",
        "php-http/discovery": "dev-php54",
        "php-http/guzzle5-adapter": "dev-php54",
        "runet-id/api-client": "^3.0@alpha"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ruvents/php-http-discovery.git"
        },
        {
            "type": "vcs",
            "url": "git@github.com:ruvents/php-http-guzzle5-adapter.git"
        }
    ]
}
```

## Использование

### Без денормализации в объекты

```php
<?php

use RunetId\ApiClient\RunetIdApiClient;

$options = [
    'key' => 'key',
    'secret' => 'secret',
];

$client = new RunetIdApiClient($options);

$client->user()->get(1); //: array

$client->user()->get(1, [
    'language' => 'en',
    'event_id' => 123
]);
```

### С денормализацией

```php
<?php

use RunetId\ApiClient\RunetIdApiClient;
use RunetId\ApiClient\Extension\DenormalizationExtension;

$options = [
    'key' => 'key',
    'secret' => 'secret',
];

$extensions = [
    new DenormalizationExtension()
];

$client = new RunetIdApiClient($options, $extensions);

$client->user()->get(1); //: UserInterface
```
