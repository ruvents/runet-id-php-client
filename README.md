# Официальный API-клиент RUNET-ID для PHP

[![GitHub license](https://img.shields.io/github/license/ruvents/runet-id-php-client.svg?style=flat-square)](https://github.com/ruvents/runet-id-php-client/blob/master/LICENSE)
[![Travis branch](https://img.shields.io/travis/ruvents/runet-id-php-client/master.svg?style=flat-square)](https://travis-ci.org/ruvents/runet-id-php-client)
[![Codecov branch](https://img.shields.io/codecov/c/github/ruvents/runet-id-php-client/master.svg?style=flat-square)](https://codecov.io/gh/ruvents/runet-id-php-client)
[![Packagist](https://img.shields.io/packagist/v/runet-id/api-client.svg?style=flat-square)](https://packagist.org/packages/runet-id/api-client)
[![Packagist Pre Release](https://img.shields.io/packagist/vpre/runet-id/api-client.svg?style=flat-square)](https://packagist.org/packages/runet-id/api-client)

[Документация по API RUNET-ID.](https://runet-id.com/apidoc/)

## Установка

Выполните установку пакетов.

`$ composer require runet-id/api-client:^3.0@dev php-http/discovery guzzlehttp/psr7 php-http/guzzle6-adapter`

Пакет `php-http/discovery` необходим для быстрого старта. Позднее Discovery можно заменить явными инъекциями HTTP-клиента и PSR-7 фабрик. Подробнее в разделе __Удаление библиотеки Discovery__.

Вместо `guzzlehttp/psr7` вы можете использовать [любую имплементацию PSR-7 сообщений](https://packagist.org/providers/psr/http-message-implementation), например, [zendframework/zend-diactoros](https://packagist.org/packages/zendframework/zend-diactoros).

Вместо `php-http/guzzle6-adapter` вы можете использовать [любую имплементацию HTTP-клиента](https://packagist.org/providers/php-http/client-implementation), например, [cURL client](https://packagist.org/packages/php-http/curl-client) или [Socket client](https://packagist.org/packages/php-http/socket-client).

## Использование

```php
<?php

use Http\Discovery\MessageFactoryDiscovery;
use RunetId\Client\RunetIdClientFactory;
use RunetId\Client\Result\SuccessResult;

$factory = new RunetIdClientFactory();
$client = $factory->create('key', 'secret');

// Запрос с использованием встроенных подсказок по endpoint-ам RUNET-ID.
$user = $client->userGet()
    // метод setLanguage доступен во всех endpoint-ах
    ->setLanguage('en')
    ->setRunetId(1)
    ->getResult();

// Метод getResult возвращает размеченный phpDoc-свойствами класс.
$runetId = $user->RunetId;
$company = $user->Work->Company->Name;

// Чтобы получить исходный массив, используйте метод getRawResult.
$arrayUser = $client->userGet()
    ->setRunetId(1)
    ->getRawResult();

// Endpoint-ы можно использовать повторно.
$roleChanger = $client
    ->eventChangeRole()
    ->setRoleId(1);

$success1 = $roleChanger
    ->setRunetId(1)
    ->getResult()
    ->Success;

$success2 = $roleChanger
    ->setRunetId(2)
    ->getResult()
    ->Success;

// Данные можно передавать в свободной форме.
$company = $client
    ->companyGet()
    // Метод setQueryData() перезаписывает все параметры.
    ->setQueryData([
        'CompanyId' => 1,
    ])
    // Метод addQueryData() добавляет параметры, используя array_merge().
    ->addQueryData([
        'Language' => 'en',
    ])
    // Метод setQueryValue() устанавливает значение конкретного параметра,
    // перезаписывая предыдущее значение.
    ->setQueryValue('EventId', 123)
    ->getResult();

// Для POST запросов также доступны аналогичные методы (add|set)FormData() и setFormValue().
$client
    ->userEdit()
    ->setFormData([
        'RunetId' => 1,
        'Email' => '1@mail.ru',
    ])
    ->addFormData([
        'FirstName' => 'Имя',
    ])
    ->setFormValue('LastName', 'Фамилия')
    ->getResult();

// Чтобы сконструировать запрос от начала до конца,
// можно воспользоваться методом custom().

/** @var SuccessResult $result */
$result = $client
    ->custom()
    ->setMethod('PUT')
    ->setEndpoint('/some/put/endpoint')
    ->setLanguage('en')
    ->setQueryValue('param', 'value')
    ->setFormData([
        'FormParam' => 'FormParamValue',
    ])
    ->setClass(SuccessResult::class)
    ->getResult();

// Отправка свободного Psr\Http\Message\RequestInterface осуществляется через метод request().
// Schema, host и заголовки аутентификации будут подставлены автоматически.
$request = MessageFactoryDiscovery::find()
    ->createRequest('GET', '/user/get?RunetId=1');
$resultArray = $client->request($request);
```

### Получение постраничных данных

При обнаружении в ответе ключа `NextPageToken` клиент автоматически итеративно получает все данные в соответствии со значением `MaxResults`.

Если `MaxResults` не был задан, то запрашиваются постранично все имеющиеся данные.

```php
<?php

// При условии наличия 900 регистраций на мероприятии и серверном ограничении в 200 сущностей:

$endpoint = $client->eventUsers();

count($endpoint->getResult()->Users); // 900 (5 запросов),
count($endpoint->setMaxResults(340)->getResult()->Users); // 340 (2 запроса).
```

### Выбрасываемые исключения

1. `Http\Client\Exception` будет выброшено при ошибке выполнения запроса. [Подробнее о классах исключений HTTPLUG](http://docs.php-http.org/en/latest/httplug/exceptions.html). В частности, 
    
    - `Http\Client\Common\Exception\ClientErrorException` будет выброшено при коде ответа 4xx,
    - `Http\Client\Common\Exception\ServerErrorException` будет выброшено при коде ответа 5xx.
    
    ```php
    <?php
 
    try {
        $client->userGet()
            ->setRunetId(1)
            ->getResult();
    } catch (Http\Client\Common\Exception\ServerErrorException $exception) {
        $statusCode = $exception->getResponse()->getStatusCode();
    }
    ```

1. `RunetId\Client\Exception\JsonDecodeException` будет выброшено при ошибке парсинга JSON.
    
    ```php
    <?php
 
    try {
        $client->userGet()
            ->setRunetId(1)
            ->getResult();
    } catch (RunetId\Client\Exception\JsonDecodeException $exception) {
        $jsonErrorMsg = $exception->getMessage();
        $jsonErrorCode = $exception->getCode();
        $invalidString = $exception->getInvalidString();
    }
    ```

1. `RunetId\Client\Exception\RunetIdException` будет выброшено при ошибке API RUNET-ID.
    
    ```php
    <?php
 
    try {
        $client->userGet()
            ->setRunetId(1)
            ->getResult();
    } catch (RunetId\Client\Exception\RunetIdException $exception) {
        $errorMessage = $exception->getMessage();
        $errorCode = $exception->getCode();
        // Метод getData() возвращает полный массив данных из ответа API.
        $data = $exception->getData();
    }
    ```

1. `RunetId\Client\Exception\ResultFactoryException` будет выброшено при ошибке создания объекта результата. В этом случае просим вас создать issue.

### Подробнее об объектах Result

```php
<?php

$result = $client
    ->userGet()
    ->setRunetId(1)
    ->getResult();

// Вы можете обращаться к неразмеченным свойствам.
$result->SomeNewProperty;

// Для простоты при запросе несуществующих в исходном массиве данных
// объект не будет генерировать исключения. Вместо этого будет возвращен null.
// Это может быть полезно при обращении к свойствам,
// которые могут быть не включены в выдачу вследствие недостаточных прав.
$result->SomeLimitedAccessProperty; // null

// Чтобы проверить существование свойства в исходном массиве, используйте exists().
$hasStatus = $result->exists('Status');

// Результат является обходимым.
foreach ($result as $key => $value) {
}
```

### Конфигурация

```php
<?php

use RunetId\Client\RunetIdClientFactory;

// Установка параметров query по умолчанию.
$factory = new RunetIdClientFactory();
$client = $factory->create(
    'key',
    'secret',
    RunetIdClientFactory::DEFAULT_URI.'?Language=en&EventId=123'
);

// Использование другого базового url.
$factory = new RunetIdClientFactory();
$client = $factory->create(
    'key',
    'secret',
    'http://localhost:8000/endpoint-prefix/?Language=en'
);
```

Поставляемая с библиотекой фабрика также позволяет использовать [любые плагины проекта PHP-HTTP](http://docs.php-http.org/en/latest/plugins/index.html). Для этого передайте массив плагинов 4-ым аргументом.

Например, для логгирования запросов при помощи PSR-3 логгера, установите пакет `php-http/logger-plugin` и подключите плагин к клиенту RUNET-ID ([подробнее в документации PHP-HTTP](http://docs.php-http.org/en/latest/plugins/logger.html)).

```php
<?php

use Http\Client\Common\Plugin\LoggerPlugin;
use RunetId\Client\RunetIdClientFactory;

$loggerPlugin = new LoggerPlugin(
    // Здесь может быть любая имплементация Psr\Log\LoggerInterface.
    new Monolog\Logger('http')
);

$factory = new RunetIdClientFactory();
$client = $factory->create(
    'key',
    'secret',
    RunetIdClientFactory::DEFAULT_URI,
    // Http\Client\Common\Plugin[]
    [$loggerPlugin]
);
```

5-ым аргументом можно передать специально сконфигурированный для создаваемого клиента экземпляр `Http\Client\HttpClient`, который будет декорирован фабрикой для работы с RUNET-ID. По умолчанию используется HTTP-клиент, переданный в конструктор фабрики или клиент, найденный Discovery.

### Удаление библиотеки Discovery

Библиотека [php-http/discovery](http://php-http.readthedocs.io/en/latest/discovery.html) позволяет находить установленные имплементации HTTP-клиента и PSR-7 фабрик и, например, использовать их в качестве инъекций по умолчанию.

Зависимость от `php-http/discovery` мягкая. Чтобы удалить данный пакет из сборки, необходимо явно передать в конструктор фабрики имплементации HTTP-клиента и PSR-7 фабрик.

Например, если в проекте используется Guzzle 6, инициализация фабрики будет выглядеть следующим образом:

```php
<?php

$httpClient = new Http\Adapter\Guzzle6\Client();
$uriFactory = new Http\Message\UriFactory\GuzzleUriFactory();
$requestFactory = new Http\Message\MessageFactory\GuzzleMessageFactory();
$streamFactory = new Http\Message\StreamFactory\GuzzleStreamFactory();

$runetIdFactory = new RunetId\Client\RunetIdClientFactory($httpClient, $uriFactory, $requestFactory, $streamFactory);
```

После этого можно удалить пакет Discovery `composer remove php-http/discovery`.

## Тестирование

`vendor/bin/simple-phpunit  --coverage-text`
