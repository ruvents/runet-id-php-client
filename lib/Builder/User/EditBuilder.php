<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractEndpointBuilder;

/**
 * @method $this setEmail(string $email)
 * @method $this setFirstName(string $firstName)
 * @method $this setLastName(string $lastName)
 * @method $this setFatherName(string $fatherName)
 * @method $this setPhoto(string $photo)
 * @method $this setPrimaryPhone(string $primaryPhone)
 * @method $this setAttributes(array $attributes)
 *
 * @method \RunetId\ApiClient\Result\User\User getResult()
 */
class EditBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\User\User',
        'endpoint' => '/user/edit',
        'method' => 'POST',
    ];
}
