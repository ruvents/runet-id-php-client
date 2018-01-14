<?php

namespace RunetId\Client\Endpoint\Company;

use RunetId\Client\Endpoint\AbstractPostEndpoint;
use RunetId\Client\Endpoint\SuccessResultTrait;

/**
 * @method $this setCompanyId(int $companyId)
 * @method $this setCode(string $code)
 * @method $this setName(string $name)
 * @method $this setFullName(string $fullName)
 * @method $this setInfo(string $info)
 * @method $this setFullInfo(string $fullInfo)
 * @method $this setLogo(string $logo)
 * @method $this setContactAddress(array $contactAddress)
 * @method $this setContactSite(string $contactSite)
 * @method $this setContactEmail(string $contactEmail)
 * @method $this setContactPhone(string $contactPhone)
 * @method $this setServiceAccounts(array $serviceAccounts)
 * @method $this setAttributes(array $attributes)
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
