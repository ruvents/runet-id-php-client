# Официальный API клиент -RUNET--ID-

## Установка

`$ composer require runet-id/api-client:^2.0@dev`

## Обзор

### RunetId\ApiClient\Client

Отправляет запрос к серверу и получает ответ. Используется библиотека [Guzzle](http://guzzlephp.org/)

```php
<?php
$config = [
    // API key (обязательный параметр)
    'key' => '123',
    // API secret (обязательный параметр)
    'secret' => '456',
    // использовать https? (по умолчанию false)
    'secure' => true,
    // хост (по умолчанию 'api.runet-id.com')
    'host' => 'api.runet-id.com'
];

$client = new RunetId\ApiClient\Client($config);
$client->get(
    // относительный путь метода API (обязательный параметр)
    $path = 'event/section/list',
    // параметры строки запроса
    $query = ['name' => 'value'],
    // заголовки
    $headers = ['name' => 'value']
);
$client->post(
    // относительный путь метода API (обязательный параметр)
    $path = 'event/section/list',
    // параметры строки запроса
    $query = ['name' => 'value'],
    // данные, передаваемые через POST
    $data = ['name' => 'value'],
    // заголовки
    $headers = ['name' => 'value']
);
```
