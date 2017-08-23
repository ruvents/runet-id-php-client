<?php

namespace RunetId\ApiClient\Denormalizer\Company;

use RunetId\ApiClient\Denormalizer\AbstractPreDenormalizer;
use RunetId\ApiClient\Model\Company\Company;

class CompanyPreDenormalizer extends AbstractPreDenormalizer
{
    /**
     * {@inheritdoc}
     */
    protected function getMap()
    {
        return [
            'id' => 'Id',
            'title' => 'Name',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClass()
    {
        return Company::className();
    }
}
