<?php

namespace RunetId\ApiClient;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RunetId\ApiClient\Exception\ApiErrorException;
use RunetId\ApiClient\Exception\JsonDecodeException;
use RunetId\ApiClient\Exception\ServerException;
use RunetId\ApiClient\Facade\UserFacade;
use Ruvents\AbstractApiClient\AbstractApiClient;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RunetIdApiClient extends AbstractApiClient
{
    /**
     * @return UserFacade
     */
    public function user()
    {
        return $this->getFacade(UserFacade::getClass());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'scheme' => 'http',
                'host' => 'api.runet-id.com',
            ])
            ->setRequired([
                'key',
                'secret',
            ])
            ->setAllowedTypes('scheme', 'string')
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('key', 'string')
            ->setAllowedTypes('secret', 'string');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContext(OptionsResolver $resolver)
    {
        /** @noinspection PhpUnusedParameterInspection */
        $resolver
            ->setDefaults([
                'authenticate' => true,
                'event_id' => null,
                'json_decode_assoc' => true,
                'language' => 'ru',
            ])
            ->setAllowedTypes('authenticate', 'bool')
            ->setAllowedTypes('event_id', ['null', 'int'])
            ->setAllowedTypes('json_decode_assoc', 'bool')
            ->setAllowedValues('language', ['ru', 'en']);
    }

    /**
     * {@inheritdoc}
     */
    protected function modifyRequest(RequestInterface &$request, array $context)
    {
        $options = $this->getOptions();

        parse_str($request->getUri()->getQuery(), $query);

        $query['Language'] = $context['language'];
        $query['EventId'] = $context['event_id'];

        $uri = $request->getUri()
            ->withScheme($options['scheme'])
            ->withHost($options['host'])
            ->withQuery(http_build_query(array_filter($query)));

        $request = $request->withUri($uri);

        if ($context['authenticate']) {
            $request = $request
                ->withHeader('APIKEY', $options['key'])
                ->withHeader('TIMESTAMP', $timestamp = $context['_time']->getTimestamp())
                ->withHeader('HASH', substr(md5($options['key'].$timestamp.$options['secret']), 0, 16));
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws ServerException
     */
    protected function validateResponse(ResponseInterface $response, array $context)
    {
        if (200 !== $code = $response->getStatusCode()) {
            throw new ServerException($context);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function decodeResponse(ResponseInterface $response, array $context)
    {
        $decoded = json_decode((string)$response->getBody(), $context['json_decode_assoc']);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonDecodeException(json_last_error_msg(), $context);
        }

        return $decoded;
    }

    /**
     * {@inheritdoc}
     */
    protected function validateData($data, array $context)
    {
        if ($context['json_decode_assoc']) {
            if (!isset($data['Error'])) {
                return;
            }

            $message = isset($data['Error']['Message']) ? $data['Error']['Message'] : '';
            $code = isset($data['Error']['Code']) ? $data['Error']['Code'] : 0;
        } else {
            if (!isset($data->Error)) {
                return;
            }

            $message = isset($data->Error->Message) ? $data->Error->Message : '';
            $code = isset($data->Error->Code) ? $data->Error->Code : 0;
        }

        throw new ApiErrorException($message, $code, $context);
    }
}
