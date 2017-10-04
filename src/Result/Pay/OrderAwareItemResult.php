<?php

namespace RunetId\ApiClient\Result\Pay;

class OrderAwareItemResult extends ItemResult
{
    /**
     * @var null|OrderResult
     */
    private $order;

    /**
     * @param array            $result
     * @param null|OrderResult $order
     */
    public function __construct(array $result, OrderResult $order = null)
    {
        parent::__construct($result);
        $this->order = $order;
    }

    /**
     * @return bool
     */
    public function isOrdered()
    {
        return null !== $this->order;
    }

    /**
     * @return null|OrderResult
     */
    public function getOrder()
    {
        return $this->order;
    }
}
