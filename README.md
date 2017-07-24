# Официальный API клиент RUNET ID для PHP

## Установка

### PHP \>=5.5

`$ composer require guzzlehttp/psr7 php-http/guzzle6-adapter runet-id/api-client:^3.0@alpha`

### PHP 5.4

Пропишите вручную в `composer.json`:

```json
{
    "require": {
        "php-http/discovery": "dev-php54",
        "php-http/guzzle5-adapter": "dev-php54"
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
    ],
    "config": {
        "platform": {
            "php": "5.4.0"
        }
    }
}
```

`$ composer require guzzlehttp/psr7 runet-id/api-client:^3.0@alpha`

### HTTP клиент

Вместо `php-http/guzzle(5|6)-adapter` вы можете использовать [любую имплементацию клиента](https://packagist.org/providers/php-http/client-implementation)

## Стандартное использование

```php
<?php

use RunetId\ApiClient\RunetIdClient;

$options = [
    'key' => 'key',
    'secret' => 'secret',
];

$client = new RunetIdClient($options);

$client->user()->get(1);
```

## Итераторы постраничных данных

Некоторые методы API (например, `/event/users`) возвращают данные постранично. Для упрощения работы с такими методами в библиотеке есть расширение `IteratorExtension`.

Во время перебора внутри цикла итератор при необходимости автоматически запрашивает следующую порцию данных.

Без использования расширения:

```php
<?php

use RunetId\ApiClient\RunetIdClient;

$client = new RunetIdClient([
    'key' => 'key',
    'secret' => 'secret',
]);

$users = $client->event()->users(/** $maxResults */1000);

// $users = ["Users" => [...], "NextPageToken" => "ZXZlMQ==", ...]
// Результирующий массив будет содержать только 200 результатов
// Чтобы получить остальное, потребуется сделать еще 4 запроса с PageToken
```

С расширением: 

```php
<?php

use RunetId\ApiClient\RunetIdClient;
use RunetId\ApiClient\Extension\IteratorExtension;

$client = new RunetIdClient(['key' => 'key', 'secret' => 'secret'], [
    new IteratorExtension(),
]);

$userIterator = $client->event()->users(1000);

foreach ($userIterator as $user) {
    var_dump($user['Email']);
}

$users = $userIterator->toArray();
```

## Денормализация в объекты

Для удобства работы с результатом запроса можно включить денормализацию.

Установите дополнительную библиотеку:

`$ composer require symfony/serializer`

```php
<?php

use RunetId\ApiClient\RunetIdClient;
use RunetId\ApiClient\Extension\DenormalizationExtension;
use RunetId\ApiClient\Model\User\User;

$client = new RunetIdClient(['key' => 'key', 'secret' => 'secret'], [
    new DenormalizationExtension(),
]);

$user = $client->user()->get(1);

var_dump($user->getEmail());
var_dump($user->getPhoto(User::PHOTO_LARGE)->getHeight());
```
