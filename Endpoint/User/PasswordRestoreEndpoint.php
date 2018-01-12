<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

/**
 * @method $this setCredential(string $credential) Email|Phone|RunetId
 */
final class PasswordRestoreEndpoint extends AbstractPostEndpoint
{
    use SuccessResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/passwordRestore';
    }
}
