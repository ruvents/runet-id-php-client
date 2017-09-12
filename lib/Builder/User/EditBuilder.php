<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setEmail(string $email)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setFatherName(string $fatherName)
 * @method $this setPhoto(string $photo)
 * @method $this setPrimaryPhone(string $primaryPhone)
 * @method $this setAttributes(array $attributes)
 *
 * @method \RunetId\ApiClient\Result\User\UserResult getResult()
 */
class EditBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\UserResult',
        'endpoint' => '/user/edit',
        'method' => 'POST',
    ];
}
