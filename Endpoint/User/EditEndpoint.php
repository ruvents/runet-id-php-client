<?php

namespace RunetId\Client\Endpoint\User;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Result\User\UserResult;

/**
 * @method $this      setAttributes(array $attributes)
 * @method $this      setEmail(string $email)
 * @method $this      setFatherName(string $fatherName)
 * @method $this      setFirstName(string $firstName)
 * @method $this      setLastName(string $lastName)
 * @method $this      setPhoto(string $photo)
 * @method $this      setPrimaryPhone(string $primaryPhone)
 * @method $this      setRunetId(int $runetId)
 * @method UserResult getResult()
 */
final class EditEndpoint extends AbstractPostEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/user/edit';
    }

    /**
     * {@inheritdoc}
     */
    protected function getClass()
    {
        return UserResult::class;
    }
}
