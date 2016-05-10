<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Facade\EventFacade;
use RunetId\ApiClient\Facade\ProfInterestFacade;
use RunetId\ApiClient\Facade\SectionFacade;
use RunetId\ApiClient\Facade\UserFacade;
use Ruvents\DataReconstructor\DataReconstructor;
use Ruvents\HttpClient\HttpClient;
use Ruvents\HttpClient\Request\Request;
use Ruvents\HttpClient\Request\Uri;
use Ruvents\HttpClient\Response\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ApiClient
 */
class ApiClient
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var ModelReconstructor
     */
    protected $modelReconstructor;

    /**
     * @param array                  $options
     * @param DataReconstructor|null $modelReconstructor
     */
    public function __construct(array $options, DataReconstructor $modelReconstructor = null)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        if (!$modelReconstructor) {
            $modelReconstructor = new ModelReconstructor($this->options['model_reconstructor']);
        }
        $this->modelReconstructor = $modelReconstructor;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $path
     * @param array  $data
     * @param array  $headers
     * @return Response
     */
    public function get($path, array $data = [], array $headers = [])
    {
        $request = $this->createRequest($path, $data, [], $headers);

        return $this->send('GET', $request);
    }

    /**
     * @param string            $path
     * @param array             $query
     * @param null|string|array $data
     * @param array             $headers
     * @param array             $files
     * @return Response
     */
    public function post($path, array $query = [], $data = null, array $headers = [], array $files = [])
    {
        $request = $this->createRequest($path, $query, $data, $headers, $files);

        return $this->send('POST', $request);
    }

    /**
     * @param int|null $runetId
     * @return UserFacade
     */
    public function user($runetId = null)
    {
        return new UserFacade($this, $this->modelReconstructor, $runetId);
    }

    /**
     * @return EventFacade
     */
    public function event()
    {
        return new EventFacade($this, $this->modelReconstructor);
    }

    /**
     * @param int|null $sectionId
     * @return SectionFacade
     */
    public function section($sectionId = null)
    {
        return new SectionFacade($this, $this->modelReconstructor, $sectionId);
    }

    /**
     * @return ProfInterestFacade
     */
    public function profInterest()
    {
        return new ProfInterestFacade($this, $this->modelReconstructor);
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'host' => 'api.runet-id.com',
                'secure' => false,
                'key' => null,
                'secret' => null,
                'model_reconstructor' => [],
            ])
            ->setRequired(['host', 'key', 'secret'])
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('secure', 'bool')
            ->setAllowedTypes('key', 'string')
            ->setAllowedTypes('secret', 'string')
            ->setAllowedTypes('model_reconstructor', 'array');
    }

    /**
     * @param string            $path
     * @param array             $query
     * @param null|string|array $data
     * @param array             $headers
     * @param array             $files
     * @return Request
     */
    protected function createRequest($path, array $query = [], $data = null, array $headers = [], array $files = [])
    {
        $hash = $this->generateHash($this->options['key'], $this->options['secret']);

        $query = array_merge([
            'ApiKey' => $this->options['key'],
            'Hash' => $hash,
        ], $query);

        $uri = Uri::createHttp($this->options['host'], $path, $query, $this->options['secure']);

        return new Request($uri, $data, $headers, $files);
    }

    /**
     * @param string  $method
     * @param Request $request
     * @return Response
     */
    protected function send($method, Request $request)
    {
        return HttpClient::send($method, $request);
    }

    /**
     * @param array $query
     */
    protected function prepareQuery(array &$query)
    {
        $hash = $this->generateHash($this->options['key'], $this->options['secret']);

        $query = array_merge([
            'ApiKey' => $this->options['key'],
            'Hash' => $hash,
        ], $query);
    }

    /**
     * @param string $key
     * @param string $secret
     * @return string
     */
    private function generateHash($key, $secret)
    {
        return md5($key.$secret);
    }
}
