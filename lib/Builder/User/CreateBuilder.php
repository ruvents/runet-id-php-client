<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setEmail(string $email)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setFatherName(string $fatherName)
 * @method $this setPhoto(string $photo)
 * @method $this setPhone(string $phone)
 * @method $this setCompany(string $company)
 * @method $this setPosition(string $position)
 * @method $this setVisible(bool $visible)
 * @method $this setAttributes(array $attributes)
 * @method $this setSubscribedForMailings(bool $subscribedForMailings)
 *
 * @method \RunetId\ApiClient\Result\User\UserResult getResult()
 */
class CreateBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\UserResult',
        'endpoint' => '/user/create',
        'method' => 'POST',
    ];
}
