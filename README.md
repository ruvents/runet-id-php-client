# Официальный API-клиент -RUNET--ID-

## Установка

`$ composer require runet-id/api-client:^2.0@alpha`

## Использование

### RunetId\ApiClient\Client

Отправляет запрос к серверу и получает ответ. Используется библиотека [RUVENTS Http Client](https://bitbucket.org/ruvents/http-client)

```php
<?php
$client = new RunetId\ApiClient\ApiClient([
    // API key (обязательный параметр)
    'key' => 'runetidkey',
    // API secret (обязательный параметр)
    'secret' => 'runetidsecret',
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
    $files = ['name' => new Ruvents\HttpClient\Request\File($path)]
);
```
Методы `Client::get` и `Client::post` возвращают объект класса `Ruvents\HttpClient\Response\Response`. [Подробнее в документации RUVENTS Http Client](https://bitbucket.org/ruvents/http-client).


##TODO
При отправке пост запроса в ряде случев возвращается или положительный ответ или ошибка, пример:
   object(Ruvents\HttpClient\Response\Response)#99 (4) {
  ["rawBody":"Ruvents\HttpClient\Response\Response":private]=>
  string(16) "{"Success":true}"
  ["code":"Ruvents\HttpClient\Response\Response":private]=>
  int(200)
  ["headers":"Ruvents\HttpClient\Response\Response":private]=>
  array(10) {
    [0]=>
    string(15) "HTTP/1.1 200 OK"
    ["SERVER"]=>
    string(5) "nginx"
    ["DATE"]=>
    string(19) "Tue, 19 Apr 2016 08"
    ["CONTENT-TYPE"]=>
    string(24) "text/json; charset=utf-8"
    ["TRANSFER-ENCODING"]=>
    string(7) "chunked"
    ["CONNECTION"]=>
    string(10) "keep-alive"
    ["SET-COOKIE"]=>
    string(79) "sessid=f6c03e0370cd34f61eb34f1405b46b7d; path=/; domain=.runet-id.com; HttpOnly"
    ["EXPIRES"]=>
    string(19) "Thu, 19 Nov 1981 08"
    ["CACHE-CONTROL"]=>
    string(62) "no-store, no-cache, must-revalidate, post-check=0, pre-check=0"
    ["PRAGMA"]=>
    string(8) "no-cache"
  }
  ["request":protected]=>
  object(Ruvents\HttpClient\Request\Request)#98 (3) {
    ["uri":"Ruvents\HttpClient\Request\Request":private]=>
    object(Ruvents\HttpClient\Request\Uri)#97 (8) {
      ["scheme":"Ruvents\HttpClient\Request\Uri":private]=>
      string(4) "http"
      ["user":"Ruvents\HttpClient\Request\Uri":private]=>
      NULL
      ["pass":"Ruvents\HttpClient\Request\Uri":private]=>
      NULL
      ["host":"Ruvents\HttpClient\Request\Uri":private]=>
      string(16) "api.runet-id.com"
      ["port":"Ruvents\HttpClient\Request\Uri":private]=>
      NULL
      ["path":"Ruvents\HttpClient\Request\Uri":private]=>
      string(14) "event/register"
      ["query":"Ruvents\HttpClient\Request\Uri":private]=>
      array(6) {
        ["ApiKey"]=>
        string(10) "n56znff68h"
        ["Timestamp"]=>
        int(1461056369)
        ["Hash"]=>
        string(16) "4b2860f309c37ec1"
        ["RunetId"]=>
        int(13012)
        ["RoleId"]=>
        int(1)
        ["UsePriority"]=>
        bool(true)
      }
      ["fragment":"Ruvents\HttpClient\Request\Uri":private]=>
      NULL
    }
    ["data":"Ruvents\HttpClient\Request\Request":private]=>
    NULL
    ["headers":"Ruvents\HttpClient\Request\Request":private]=>
    array(1) {
      ["Expect"]=>
      string(0) ""
    }
  }
}

Необходимо предусмотреть модель для подобных ответов