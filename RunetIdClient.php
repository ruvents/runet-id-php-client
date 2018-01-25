<?php

namespace RunetId\Client;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RunetId\Client\Endpoint\QueryHelper;
use RunetId\Client\Exception\JsonDecodeException;
use RunetId\Client\Exception\RunetIdException;

/**
 * @method Endpoint\Company\EditEndpoint               companyEdit()
 * @method Endpoint\Company\GetEndpoint                companyGet()
 * @method Endpoint\Competence\ResultEndpoint          competenceResult()
 * @method Endpoint\Competence\TestsEndpoint           competenceTests()
 * @method Endpoint\Event\ChangeRoleEndpoint           eventChangeRole()
 * @method Endpoint\Event\CompaniesEndpoint            eventCompanies()
 * @method Endpoint\Event\HallsEndpoint                eventHalls()
 * @method Endpoint\Event\RegisterEndpoint             eventRegister()
 * @method Endpoint\Event\RolesEndpoint                eventRoles()
 * @method Endpoint\Event\UsersEndpoint                eventUsers()
 * @method Endpoint\Pay\AddEndpoint                    payAdd()
 * @method Endpoint\Pay\CouponEndpoint                 payCoupon()
 * @method Endpoint\Pay\DeleteEndpoint                 payDelete()
 * @method Endpoint\Pay\EditEndpoint                   payEdit()
 * @method Endpoint\Pay\FilterListEndpoint             payFilterList()
 * @method Endpoint\Pay\ItemsEndpoint                  payItems()
 * @method Endpoint\Pay\ListEndpoint                   payList()
 * @method Endpoint\Pay\ProductsEndpoint               payProducts()
 * @method Endpoint\Pay\UrlEndpoint                    payUrl()
 * @method Endpoint\Section\AddFavoriteEndpoint        sectionAddFavorite()
 * @method Endpoint\Section\DeleteFavoriteEndpoint     sectionDeleteFavorite()
 * @method Endpoint\Section\FavoritesEndpoint          sectionFavorites()
 * @method Endpoint\Section\InfoEndpoint               sectionInfo()
 * @method Endpoint\Section\ListEndpoint               sectionList()
 * @method Endpoint\Section\ReportsEndpoint            sectionReports()
 * @method Endpoint\Section\UserEndpoint               sectionUser()
 * @method Endpoint\User\AddressEndpoint               userAddress()
 * @method Endpoint\User\AuthEndpoint                  userAuth()
 * @method Endpoint\User\CreateEndpoint                userCreate()
 * @method Endpoint\User\EditEndpoint                  userEdit()
 * @method Endpoint\User\GetEndpoint                   userGet()
 * @method Endpoint\User\LoginEndpoint                 userLogin()
 * @method Endpoint\User\PasswordChangeEndpoint        userPasswordChange()
 * @method Endpoint\User\ProfessionalinterestsEndpoint userProfessionalinterests()
 * @method Endpoint\User\SearchEndpoint                userSearch()
 * @method Endpoint\User\SectionsEndpoint              userSections()
 * @method Endpoint\CustomEndpoint                     custom()
 */
final class RunetIdClient
{
    private $httpClient;
    private $requestFactory;
    private $streamFactory;

    public function __construct(HttpClient $httpClient = null, RequestFactory $requestFactory = null, StreamFactory $streamFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        $this->streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @throws \BadMethodCallException
     *
     * @return Endpoint\AbstractEndpoint
     */
    public function __call($name, array $arguments)
    {
        $class = $this->getEndpointClass($name);

        if (!class_exists($class)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s() is not defined.', static::class, $name));
        }

        return new $class($this, $this->requestFactory, $this->streamFactory);
    }

    /**
     * @param RequestInterface $request
     *
     * @throws \Http\Client\Exception When an error happens during processing the request
     * @throws JsonDecodeException    When json_decode fails
     * @throws RunetIdException       When RUNET-ID API returns an error
     *
     * @return mixed
     */
    public function request(RequestInterface $request)
    {
        $data = $this->doRequest($request);

        if (isset($data['NextPageToken'])) {
            return $this->requestPaginated($data, $request);
        }

        return $data;
    }

    /**
     * @param RequestInterface $request
     *
     * @return mixed
     */
    private function doRequest(RequestInterface $request)
    {
        $response = $this->httpClient->sendRequest($request);
        $data = $this->decodeResponse($response);
        $this->detectError($data);

        return $data;
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws JsonDecodeException When json_decode fails
     *
     * @return mixed
     */
    private function decodeResponse(ResponseInterface $response)
    {
        $string = (string) $response->getBody();
        $data = json_decode($string, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonDecodeException($string);
        }

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @throws RunetIdException When RUNET-ID API returns an error
     *
     * @return void
     */
    private function detectError($data)
    {
        if (isset($data['Error'])) {
            throw new RunetIdException($data);
        }
    }

    /**
     * @param array            $data
     * @param RequestInterface $request
     *
     * @return array
     */
    private function requestPaginated(array $data, RequestInterface $request)
    {
        $key = $this->getPaginatedItemsKey($data);
        $items = $data[$key];
        $queryHelper = new QueryHelper($request->getUri()->getQuery());
        $maxResults = $queryHelper->getValue('MaxResults');

        if (is_numeric($maxResults) && $maxResults >= 0) {
            $maxResults -= count($items);
        } else {
            $maxResults = null;
        }

        while (isset($data['NextPageToken']) && (null === $maxResults || $maxResults > 0)) {
            $request = $queryHelper
                ->setValue('PageToken', $data['NextPageToken'])
                ->setValue('MaxResults', $maxResults)
                ->apply($request);

            $data = $this->doRequest($request);
            $newItems = $data[$key];
            $items = $data[$key] = array_merge($items, $newItems);

            if (null !== $maxResults) {
                $maxResults -= count($newItems);
            }
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @throws \LogicException
     *
     * @return int|string
     */
    private function getPaginatedItemsKey(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                return $key;
            }
        }

        throw new \LogicException('Failed to detect paginated data key.');
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function getEndpointClass($name)
    {
        return 'RunetId\Client\Endpoint\\'.ucfirst(preg_replace('/[A-Z]/', '\\\$0', $name, 1)).'Endpoint';
    }
}
