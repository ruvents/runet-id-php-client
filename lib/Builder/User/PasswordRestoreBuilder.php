<?php

namespace RunetId\ApiClient\Builder\User;

use RunetId\ApiClient\Builder\AbstractBuilder;

/**
 * @method $this setCredential(string $credential) Email|Phone|RunetId
 *
 * @method \RunetId\ApiClient\Result\SuccessResult getResult()
 */
class PasswordRestoreBuilder extends AbstractBuilder
{
    /**
     * @var array
     */
    public $context = [
        'class' => 'RunetId\ApiClient\Result\SuccessResult',
        'endpoint' => '/user/passwordRestore',
        'method' => 'POST',
    ];
}
