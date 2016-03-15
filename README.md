# Официальный API клиент -RUNET--ID-

## Установка

`$ composer require runet-id/api-client:^2.0@dev`

## Обзор

### RunetId\ApiClient\Client

Отправляет запрос к серверу и получает ответ. Используется библиотека [Guzzle](http://guzzlephp.org/)

```php
<?php
$client = new RunetId\ApiClient\Client([
    // API key (обязательный параметр)
    'key' => '123',
    // API secret (обязательный параметр)
    'secret' => '456',
    // использовать https? (по умолчанию: false)
    'secure' => true,
    // хост (по умолчанию: 'api.runet-id.com')
    'host' => 'api.runet-id.com'
]);

// отправка GET-запроса
$client->get(
    // относительный путь метода API (обязательный параметр)
    $path = 'event/section/list',
    // параметры строки запроса
    $query = ['key' => 'value'],
    // заголовки
    $headers = ['key' => 'value']
);

// отправка POST-запроса
$client->post(
    // относительный путь метода API (обязательный параметр)
    $path = 'event/section/list',
    // параметры строки запроса
    $query = ['key' => 'value'],
    // данные, передаваемые через POST
    $data = ['key' => 'value'],
    // заголовки
    $headers = ['key' => 'value'],
    // тело
    $body = fopen('/path/to/file', 'r')
);
```
Методы `Client::get` и `Client::post` возвращают объект класса `GuzzleHttp\Psr7\Response`. Подробнее [в документации Guzzle](http://docs.guzzlephp.org/en/latest/quickstart.html#using-responses).

В теле POST-запроса можно передавать как строку, так и ресурс или поток. Подробнее [в документации Guzzle](http://docs.guzzlephp.org/en/latest/request-options.html#body).
