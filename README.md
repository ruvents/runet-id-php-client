# Официальный API-клиент RUNET-ID для PHP

[![GitHub license](https://img.shields.io/github/license/ruvents/runet-id-php-client.svg?style=flat-square)](https://github.com/ruvents/runet-id-php-client/blob/master/LICENSE)
[![Travis branch](https://img.shields.io/travis/ruvents/runet-id-php-client/master.svg?style=flat-square)](https://travis-ci.org/ruvents/runet-id-php-client)
[![Codecov branch](https://img.shields.io/codecov/c/github/ruvents/runet-id-php-client/master.svg?style=flat-square)](https://codecov.io/gh/ruvents/runet-id-php-client)
[![Packagist](https://img.shields.io/packagist/v/runet-id/api-client.svg?style=flat-square)](https://packagist.org/packages/runet-id/api-client)
[![Packagist Pre Release](https://img.shields.io/packagist/vpre/runet-id/api-client.svg?style=flat-square)](https://packagist.org/packages/runet-id/api-client)

[Документация по API RUNET-ID.](https://runet-id.com/apidoc/)

## Установка

Выполните установку пакетов:

`$ composer require runet-id/api-client:^3.0@dev php-http/discovery guzzlehttp/psr7 php-http/guzzle6-adapter`

### Библиотеки для работы с HTTP-запросами

Вместо `php-http/guzzle6-adapter` вы можете использовать [любую имплементацию клиента](https://packagist.org/providers/php-http/client-implementation).

Вместо `guzzlehttp/psr7` вы можете использовать любую имплементацию PSR-7 сообщений, например, [zendframework/zend-diactoros](https://packagist.org/packages/zendframework/zend-diactoros) или [slim/slim](https://packagist.org/packages/slim/slim).

## Использование

```php
<?php

use Http\Discovery\MessageFactoryDiscovery;
use RunetId\Client\RunetIdClientFactory;
use RunetId\Client\Result\SuccessResult;

$factory = new RunetIdClientFactory();
$client = $factory->create('key', 'secret');

// запрос с использованием встроенных подсказок по endpoint-ам RUNET-ID
$user = $client->userGet()
    // метод setLanguage доступен во всех endpoint-ах
    ->setLanguage('en')
    ->setRunetId(1)
    ->getResult();

// метод getResult возвращает размеченный phpDoc-свойствами класс
$runetId = $user->RunetId;
$company = $user->Work->Company->Name;

// чтобы получить исходный массив, используйте метод getRawResult
$arrayUser = $client->userGet()
    ->setRunetId(1)
    ->getRawResult();

// endpoint-ы можно использовать повторно
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

// данные можно передавать в свободной форме
$company = $client
    ->companyGet()
    // перезаписывает все параметры
    ->setQueryData([
        'CompanyId' => 1,
    ])
    // добавляет параметры (используется array_merge())
    ->addQueryData([
        'Language' => 'en',
    ])
    // устанавливает значение конкретного параметра
    ->setQueryValue('EventId', 123)
    ->getResult();

// для POST запросов также доступны аналогичные методы (add|set)FormData и setFormValue
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

// чтобы сконструировать запрос от начала до конца, можно воспользоваться классом CustomEndpoint
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

// отправка свободного Psr\Http\Message\RequestInterface
// (schema, host и заголовки аутентификации будут подставлены автоматически)
$request = MessageFactoryDiscovery::find()
    ->createRequest('GET', '/user/get?RunetId=1');
$resultArray = $client->request($request);
```

### Выбрасываемые исключения

```php
<?php

use RunetId\Client\Exception\JsonDecodeException;
use RunetId\Client\Exception\ResultFactoryException;
use RunetId\Client\Exception\RunetIdException;
use RunetId\Client\RunetIdClientFactory;

try {
    $factory = new RunetIdClientFactory();
    $factory->create('key', 'secret')
        ->userGet()
        ->setRunetId(1)
        ->getResult();
} catch (\Http\Client\Exception $exception) {
    // выбрасывается при ошибке выполнения запроса
    // http://docs.php-http.org/en/latest/httplug/exceptions.html
} catch (JsonDecodeException $exception) {
    // выбрасывается при ошибке парсинга JSON
    $jsonErrorMsg = $exception->getMessage();
    $jsonErrorCode = $exception->getCode();
    $invalidString = $exception->getInvalidString();
} catch (RunetIdException $exception) {
     // выбрасывается при ошибке API RUNET-ID
     $errorMessage = $exception->getMessage();
     $errorCode = $exception->getCode();
     // полный массив данных из ответа API
     $data = $exception->getData();
} catch (ResultFactoryException $exception) {
     // выбрасывается при ошибке создания объекта результата
     // если такое исключение будет выброшено, напишите issue
}
```

### Конфигурация

```php
<?php

use RunetId\Client\RunetIdClientFactory;

// установка параметров query по умолчанию
$factory = new RunetIdClientFactory();
$client = $factory->create(
    'key',
    'secret',
    RunetIdClientFactory::DEFAULT_URI.'?Language=en&EventId=123'
);

// использование другого базового url
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
    // здесь может быть любая имплементация Psr\Log\LoggerInterface
    new \Monolog\Logger('http')
);

$factory = new RunetIdClientFactory();
$client = $factory->create(
    'key',
    'secret',
    RunetIdClientFactory::DEFAULT_URI,
    // массив Http\Client\Common\Plugin[]
    [$loggerPlugin]
);
```

5-ым аргументом фабрики можно передать готовый объект `Http\Client\HttpClient` вместо того, чтобы полагаться на `Http\Discovery\HttpClientDiscovery`.

## Тестирование

`vendor/bin/simple-phpunit  --coverage-text`
