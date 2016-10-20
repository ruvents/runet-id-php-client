<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Exception\UnexpectedValueException;
use RunetId\ApiClient\Facade\EventFacade;
use RunetId\ApiClient\Facade\PayFacade;
use RunetId\ApiClient\Facade\ProfInterestFacade;
use RunetId\ApiClient\Facade\SectionFacade;
use RunetId\ApiClient\Facade\UserFacade;
use Ruvents\DataReconstructor\DataReconstructor;
use Ruvents\HttpClient\HttpClient;
use Ruvents\HttpClient\Request\Request;
use Ruvents\HttpClient\Request\Uri;
use Ruvents\HttpClient\Response\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Exception as ResolverException;
use Ruvents\HttpClient\Exception as HttpException;

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
     * @throws ResolverException\AccessException
     * @throws ResolverException\InvalidOptionsException
     * @throws ResolverException\MissingOptionsException
     * @throws ResolverException\NoSuchOptionException
     * @throws ResolverException\OptionDefinitionException
     * @throws ResolverException\UndefinedOptionsException
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
     * @return string[]
     */
    public function getSupportedLocales()
    {
        return array('ru', 'en');
    }

    /**
     * @param string $locale
     * @return $this
     * @throws UnexpectedValueException
     */
    public function setLocale($locale)
    {
        if (!in_array($locale, $this->getSupportedLocales(), true)) {
            throw new UnexpectedValueException(sprintf(
                'Locale "%s" is not supported', $locale
            ));
        }

        $this->options['locale'] = $locale;

        return $this;
    }

    /**
     * @param string $path
     * @param array  $data
     * @param array  $headers
     * @return Response
     * @throws HttpException\RuntimeException
     * @throws HttpException\CurlException
     * @throws HttpException\InvalidArgumentException
     */
    public function get($path, array $data = array(), array $headers = array())
    {
        $request = $this->createRequest($path, $data, array(), $headers);

        return $this->send('GET', $request);
    }

    /**
     * @param string            $path
     * @param array             $query
     * @param null|string|array $data
     * @param array             $headers
     * @param array             $files
     * @return Response
     * @throws HttpException\RuntimeException
     * @throws HttpException\CurlException
     * @throws HttpException\InvalidArgumentException
     */
    public function post($path, array $query = array(), $data = null, array $headers = array(), array $files = array())
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
     * @return PayFacade
     */
    public function pay()
    {
        return new PayFacade($this, $this->modelReconstructor);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws ResolverException\AccessException
     * @throws ResolverException\UndefinedOptionsException
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'host' => 'api.runet-id.com',
                'stage' => '',
                'secure' => false,
                'key' => null,
                'secret' => null,
                'model_reconstructor' => array(),
                'locale' => 'ru',
            ))
            ->setRequired(array('host', 'key', 'secret'))
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('stage', 'string')
            ->setAllowedTypes('secure', 'bool')
            ->setAllowedTypes('key', 'string')
            ->setAllowedTypes('secret', 'string')
            ->setAllowedTypes('model_reconstructor', 'array')
            ->setAllowedValues('locale', $this->getSupportedLocales());
    }

    /**
     * @param string            $path
     * @param array             $query
     * @param null|string|array $data
     * @param array             $headers
     * @param array             $files
     * @return Request
     * @throws HttpException\InvalidArgumentException
     */
    protected function createRequest(
        $path, array $query = array(), $data = null, array $headers = array(), array $files = array()
    ) {
        $query = array_merge(array(
            'ApiKey' => $this->options['key'],
            'Hash' => $this->generateHash($this->options['key'], $this->options['secret']),
            'Locale' => $this->options['locale'],
        ), $query);

        $uri = Uri::createHttp(
            $this->options['host'],
            $this->options['stage'].'/'.$path,
            $query,
            $this->options['secure']
        );

        return new Request($uri, $data, $headers, $files);
    }

    /**
     * @param string  $method
     * @param Request $request
     * @return Response
     * @throws HttpException\RuntimeException
     * @throws HttpException\CurlException
     */
    protected function send($method, Request $request)
    {
        return HttpClient::send($method, $request);
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
