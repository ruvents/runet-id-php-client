<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Result\User\UserResult;

/**
 * @method $this      setEmail(string $email)
 * @method $this      setFirstName(string $firstName)
 * @method $this      setLastName(string $lastName)
 * @method $this      setFatherName(string $fatherName)
 * @method $this      setPhoto(string $photo)
 * @method $this      setPhone(string $phone)
 * @method $this      setCompany(string $company)
 * @method $this      setPosition(string $position)
 * @method $this      setVisible(bool $visible)
 * @method $this      setAttributes(array $attributes)
 * @method $this      setSubscribedForMailings(bool $subscribedForMailings)
 * @method UserResult getResult()
 */
final class CreateEndpoint extends AbstractPostEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/create';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return UserResult::class;
    }
}
