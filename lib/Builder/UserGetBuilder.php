<?php

namespace RunetId\ApiClient\Builder;

use RunetId\ApiClient\Model\User\User;
use RunetId\ApiClient\Model\User\UserRunetIdInterface;

/**
 * @method $this setEmail(string $email)
 *
 * @method User getResult()
 */
class UserGetBuilder extends AbstractEndpointBuilder
{
    /**
     * @var array
     */
    public $context = [
        'endpoint' => '/user/get',
        'method' => 'GET',
    ];

    /**
     * @param int|UserRunetIdInterface $runetId
     *
     * @return $this
     */
    public function setRunetId($runetId)
    {
        return $this->setQueryParam('RunetId', ArgHelper::getUserRunetId($runetId));
    }

    /**
     * @param string|string[] $builders
     *
     * @return $this
     */
    public function setBuilders($builders)
    {
        if (is_array($builders)) {
            $builders = implode(',', $builders);
        }

        return $this->setQueryParam('Builders', $builders);
    }

    /**
     * {@inheritdoc}
     */
    protected function getResultClass()
    {
        return 'RunetId\ApiClient\Model\User\User';
    }
}
