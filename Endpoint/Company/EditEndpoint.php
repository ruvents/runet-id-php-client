<?php

namespace RunetId\Client\Endpoint\Company;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

/**
 * @method $this setAttributes(array $attributes)
 * @method $this setCode(string $code)
 * @method $this setCompanyId(int $companyId)
 * @method $this setContactAddress(array $contactAddress)
 * @method $this setFullInfo(string $fullInfo)
 * @method $this setFullName(string $fullName)
 * @method $this setInfo(string $info)
 * @method $this setName(string $name)
 */
final class EditEndpoint extends AbstractPostEndpoint
{
    use SuccessResultTrait;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return '/company/edit';
    }
}
