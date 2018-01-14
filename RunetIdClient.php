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
 * @method Endpoint\Pay\ItemsEndpoint                  payItems()
 * @method Endpoint\Pay\ListEndpoint                   payList()
 * @method Endpoint\Pay\ProductsEndpoint               payProducts()
 * @method Endpoint\Pay\UrlEndpoint                    payUrl()
 * @method Endpoint\Section\AddFavoriteEndpoint        sectionAddFavorite()
 * @method Endpoint\Section\DeleteFavoriteEndpoint     sectionDeleteFavorite()
 * @method Endpoint\Section\FavoritesEndpoint          sectionFavorites()
 * @method Endpoint\Section\InfoEndpoint               sectionInfo()
 * @method Endpoint\Section\ListEndpoint               sectionList()
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
        $response = $this->httpClient->sendRequest($request);
        $data = $this->decodeResponse($response);
        $this->detectError($data);

        return $data;
    }

    /**
     * @param RequestInterface $request
     * @param int              $limit
     *
     * @throws \Http\Client\Exception When an error happens during processing the request
     * @throws JsonDecodeException    When json_decode fails
     * @throws RunetIdException       When RUNET-ID API returns an error
     *
     * @return mixed
     */
    public function requestPaginated(RequestInterface $request, $limit = -1)
    {
        $queryHelper = new QueryHelper();
        $limited = $limit >= 0;
        $data = [];

        do {
            $queryHelper->setValue('PageToken', isset($data['NextPageToken']) ? $data['NextPageToken'] : null);

            if ($limited) {
                $maxResults = $limit < 200 ? $limit : 200;
                $limit -= $maxResults;
                $queryHelper->setValue('MaxResults', $maxResults);
            }

            $oldData = $data;
            $request = $queryHelper->apply($request);
            $data = $this->request($request);

            foreach ($data as $key => &$value) {
                if (is_array($value) && isset($oldData[$key])) {
                    $value = array_merge($oldData[$key], $value);
                }
            }
        } while (isset($data['NextPageToken']) && (!$limited || $limit > 0));

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
     * @param string $name
     *
     * @return string
     */
    private function getEndpointClass($name)
    {
        return 'RunetId\Client\Endpoint\\'.ucfirst(preg_replace('/[A-Z]/', '\\\$0', $name, 1)).'Endpoint';
    }
}
