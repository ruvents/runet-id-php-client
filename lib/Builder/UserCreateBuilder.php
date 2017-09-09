<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\Model\User\User;

/**
 * @method $this setEmail(string $email)
 * @method $this setLastName(string $lastName)
 * @method $this setFirstName(string $firstName)
 * @method $this setFatherName(string $fatherName)
 * @method $this setPhone(string $phone)
 * @method $this setPhoto(string $photo)
 * @method $this setCompany(string $company)
 * @method $this setPosition(string $position)
 * @method $this setAttributes(string $attributes)
 * @method $this setVisible(string $visible)
 * @method $this setSubscribedForMailings(string $subscribedForMailings)
 *
 * @method User getResult()
 */
class UserCreateBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/create',
        'method' => 'POST',
    ];

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return 'RunetId\ApiClient\Model\User\User';
    }
}
