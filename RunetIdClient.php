<?php

namespace RunetId\Client;

use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RunetId\Client\Endpoint\AbstractEndpoint;
use RunetId\Client\Endpoint\QueryHelper;
use RunetId\Client\Exception\JsonDecodeException;
use RunetId\Client\Exception\RunetIdException;

/**
 * @method Endpoint\Company\EditEndpoint               companyEdit()
 * @method Endpoint\Company\GetEndpoint                companyGet()
 * @method Endpoint\Company\ListEndpoint               companyList()
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

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return AbstractEndpoint
     */
    public function __call($name, array $arguments)
    {
        $class = $this->getEndpointClass($name);

        if (!class_exists($class)) {
            throw new \BadMethodCallException(sprintf('Method %s::%s() is not defined.', static::class, $name));
        }

        return new $class($this);
    }

    /**
     * @param RequestInterface $request
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
     * @param string           $offset
     * @param int              $limit
     *
     * @return mixed
     */
    public function requestPaginated(RequestInterface $request, $offset, $limit = -1)
    {
        $queryHelper = new QueryHelper();
        $limited = $limit >= 0;
        $data = [$offset => []];

        do {
            $pageToken = isset($data['NextPageToken']) ? $data['NextPageToken'] : null;
            $maxResults = $limited && $limit < 200 ? $limit : 200;

            $request = $queryHelper
                ->setValue('PageToken', $pageToken)
                ->setValue('MaxResults', $maxResults)
                ->apply($request);

            $newData = $this->request($request);

            if ($limited) {
                $limit -= count($newData[$offset]);
            }

            $newData[$offset] = array_merge($data[$offset], $newData[$offset]);
            $data = $newData;
        } while (isset($data['NextPageToken']) && (!$limited || $limit > 0));

        return $data;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    private function decodeResponse(ResponseInterface $response)
    {
        $data = json_decode((string) $response->getBody(), true);

        if (JSON_ERROR_NONE !== $code = json_last_error()) {
            throw new JsonDecodeException(json_last_error_msg(), $code);
        }

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @throws RunetIdException
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