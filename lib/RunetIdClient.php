<?php

namespace RunetId\ApiClient;

use RunetId\ApiClient\Service\RunetIdService;
use Ruvents\AbstractApiClient\AbstractApiClient;

/**
 * @method Builder\Event\RolesBuilder eventRoles()
 * @method Builder\Event\UsersBuilder eventUsers()
 * @method Builder\Pay\AddBuilder payAdd()
 * @method Builder\Pay\CouponBuilder payCoupon()
 * @method Builder\Pay\DeleteBuilder payDelete()
 * @method Builder\Pay\EditBuilder payEdit()
 * @method Builder\Pay\ItemsBuilder payItems()
 * @method Builder\Pay\ListBuilder payList()
 * @method Builder\Pay\ProductsBuilder payProducts()
 * @method Builder\Pay\UrlBuilder payUrl()
 * @method Builder\User\AddressBuilder userAddress()
 * @method Builder\User\AuthBuilder userAuth()
 * @method Builder\User\CreateBuilder userCreate()
 * @method Builder\User\EditBuilder userEdit()
 * @method Builder\User\GetBuilder userGet()
 * @method Builder\User\LoginBuilder userLogin()
 * @method Builder\User\PasswordChangeBuilder userPasswordChange()
 * @method Builder\User\ProfessionalinterestsBuilder userProfessionalinterests()
 * @method Builder\User\SearchBuilder userSearch()
 * @method Builder\User\SectionsBuilder userSections()
 */
class RunetIdClient extends AbstractApiClient
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $defaultContext = [], array $extensions = [], RunetIdService $service = null)
    {
        parent::__construct($service ?: new RunetIdService(), $defaultContext, $extensions);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return Builder\AbstractBuilder
     * @throws \BadMethodCallException
     */
    public function __call($name, array $arguments)
    {
        if (1 !== preg_match('/^(\w+?)([A-Z].*)$/', $name, $matches)) {
            throw new \BadMethodCallException(sprintf('Method RunetId\ApiClient\RunetIdClient::%s is not defined.', $name));
        }

        $class = __NAMESPACE__.'\Builder\\'.ucfirst($matches[1]).'\\'.$matches[2].'Builder';

        return new $class($this);
    }
}
