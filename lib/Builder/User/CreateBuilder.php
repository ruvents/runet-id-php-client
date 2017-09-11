<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;

/**
 * @method $this setEmail(string $email)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setFatherName(string $fatherName)
 * @method $this setPhoto(string $photo)
 * @method $this setPhone(string $phone)
 * @method $this setCompany(string $company)
 * @method $this setPosition(string $position)
 * @method $this setVisible(string $visible)
 * @method $this setAttributes(string $attributes)
 * @method $this setSubscribedForMailings(string $subscribedForMailings)
 *
 * @method \RunetId\ApiClient\Result\User\User getResult()
 */
class CreateBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\User',
        'endpoint' => '/user/create',
        'method' => 'POST',
    ];
}
