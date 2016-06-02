# Официальный API-клиент -RUNET--ID-

Отправляет запрос к RUNET-ID и возвращает ответ в объектно-ориентированном виде.

Использует библиотеки [RUVENTS Http Client](https://bitbucket.org/ruvents/http-client) и [RUVENTS Data Reconstructor](https://bitbucket.org/ruvents/data-reconstructor)

## Установка

`$ composer require runet-id/api-client:^2.0@alpha`

## Инициализация объекта клиента

```php
<?php

use RunetId\ApiClient\ApiClient;

$client = new ApiClient($options = [
    'key' => 'runetidkey',
    'secret' => 'runetidsecret',
]);
?>
```

## Конфигурация

```php
<?php

$options = [
    // API key (обязательный параметр)
    'key' => 'runetidkey',
    // API secret (обязательный параметр)
    'secret' => 'runetidsecret',
    // хост (по умолчанию: 'api.runet-id.com')
    'host' => 'api.runet-id.com',
    // использовать https? (по умолчанию: false)
    'secure' => true,
];
```

## Примеры построения запроса встроенными методами

Все методы возвращают объекты или массивы объектов соответствующих классов. По умолчанию это классы из неймспейса `RunetId\ApiClient\Model`.

```php
<?php

use RunetId\ApiClient\ApiClient;
use RunetId\ApiClient\Model\User\Status;

/** @var ApiClient $client */

$user = $client->user($runetId = 1)->get();
$user = $client->user()->getByToken('123asd3r34rsdawd3');
$users = $client->user()->search('Поиск', $maxResults = 10);

$event = $client->event()->get();
$client->event()->changeRole($runetId = 1, Status::ROLE_ORGANIZER);
$users = $client->event()->users($maxResults = 10, [Status::ROLE_MASS_MEDIA, Status::ROLE_PARTNER]);

$section = $client->section($sectionId = 1)->get($withReports = true);
$sections = $client->section()->getAll($fromUpdateTime = new \DateTime(), $withDeleted = false, $withReports = true);
?>
```

## Свободный запрос

```php
<?php

use RunetId\ApiClient\ApiClient;
use Ruvents\HttpClient\Request\File;

/** @var ApiClient $client */

// отправка GET-запроса
$client->get(
    // относительный путь метода API (обязательный параметр)
    $path = 'event/section/list',
    // параметры строки запроса
    $query = ['name' => 'value'],
    // заголовки
    $headers = ['name' => 'value']
);

// отправка POST-запроса
$client->post(
    // относительный путь метода API (обязательный параметр)
    $path = 'event/section/list',
    // параметры строки запроса
    $query = ['name' => 'value'],
    // данные (строка, или массив данных)
    $data = ['name' => 'value'],
    // заголовки
    $headers = ['name' => 'value'],
    // файлы
    $files = ['name' => new File('path/to/file')]
);
```

Методы `Client::get` и `Client::post` возвращают объект класса `Ruvents\HttpClient\Response\Response`. [Подробнее в документации RUVENTS Http Client](https://bitbucket.org/ruvents/http-client).
