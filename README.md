# Официальный API клиент RUNET ID для PHP

## Установка

### PHP \>=5.5

Выполните установку пакетов:

`$ composer require guzzlehttp/psr7 php-http/guzzle6-adapter runet-id/api-client:^3.0@beta`

### PHP 5.4

Пропишите вручную в `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ruvents/php-http-discovery.git"
        },
        {
            "type": "vcs",
            "url": "git@github.com:ruvents/php-http-guzzle5-adapter.git"
        }
    ],
    "config": {
        "platform": {
            "php": "5.4.0"
        }
    }
}
```

И установите пакеты:

`$ composer require php-http/discovery:dev-php54 php-http/guzzle5-adapter:dev-php54 guzzlehttp/psr7 runet-id/api-client:^3.0@beta`

### Библиотеки для работы с HTTP-запросами

Вместо `php-http/guzzle(5|6)-adapter` вы можете использовать [любую имплементацию клиента](https://packagist.org/providers/php-http/client-implementation).

Вместо `guzzlehttp/psr7` вы можете использовать любую имплементацию psr7 сообщений, например, [zendframework/zend-diactoros](https://packagist.org/packages/zendframework/zend-diactoros) или [slim/slim](https://packagist.org/packages/slim/slim).

## Использование

```php
<?php

use RunetId\ApiClient\RunetIdClient;

$client = new RunetIdClient([
    'key' => 'key',
    'secret' => 'secret',
]);

$user = $client->userGet()
    ->setRunetId(1)
    ->getResult();

var_dump($user->RunetId);
var_dump($user->Status->RoleTitle);
```
