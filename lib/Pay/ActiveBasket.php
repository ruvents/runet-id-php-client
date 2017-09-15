<?php

namespace RunetId\ApiClient\Pay;

use RunetId\ApiClient\ArgumentHelper\ArgumentHelper;
use RunetId\ApiClient\ArgumentHelper\PayItemIdInterface;
use RunetId\ApiClient\ArgumentHelper\PayProductIdInterface;
use RunetId\ApiClient\ArgumentHelper\UserRunetIdInterface;
use RunetId\ApiClient\Exception\RunetIdException;
use RunetId\ApiClient\Result\Pay\ItemResult;
use RunetId\ApiClient\Result\Pay\OrderResult;
use RunetId\ApiClient\RunetIdClient;
use Ruvents\AbstractApiClient\Exception\ApiExceptionInterface;

class ActiveBasket
{
    /**
     * @var RunetIdClient
     */
    private $client;

    /**
     * @var int
     */
    private $payerRunetId;

    /**
     * @var ItemResult[]
     */
    private $items = [];

    /**
     * @var OrderResult[]
     */
    private $orders = [];

    /**
     * @param RunetIdClient            $client
     * @param int|UserRunetIdInterface $payer
     *
     * @throws ApiExceptionInterface
     */
    public function __construct(RunetIdClient $client, $payer)
    {
        $this->client = $client;
        $this->payerRunetId = ArgumentHelper::getUserRunetId($payer);
        $this->reload();
    }

    /**
     * @return int
     */
    public function getPayerRunetId()
    {
        return $this->payerRunetId;
    }

    /**
     * @return ItemResult[]
     */
    public function getItems()
    {
        return array_values($this->items);
    }

    /**
     * @return OrderResult[]
     */
    public function getOrders()
    {
        return array_values($this->orders);
    }

    /**
     * @param int|UserRunetIdInterface  $owner
     * @param int|PayProductIdInterface $product
     *
     * @return ItemResult
     * @throws ApiExceptionInterface|RunetIdException
     */
    public function addItem($owner, $product)
    {
        $item = $this->client
            ->payAdd()
            ->setPayerRunetId($this->payerRunetId)
            ->setOwnerRunetId($owner)
            ->setProductId($product)
            ->getResult();

        return $this->items[$item->Id] = $item;
    }

    /**
     * @param int|PayItemIdInterface $item
     *
     * @throws ApiExceptionInterface|RunetIdException
     */
    public function deleteItem($item)
    {
        $item = ArgumentHelper::getPayItemId($item);

        $this->client
            ->payDelete()
            ->setPayerRunetId($this->payerRunetId)
            ->setOrderItemId($item)
            ->getResult();

        if (isset($this->items[$item])) {
            unset($this->items[$item]);
        }
    }

    /**
     * @param string                              $coupon
     * @param int|UserRunetIdInterface|ItemResult $ownerOrItem
     * @param null|int|PayProductIdInterface      $product
     *
     * @return string
     * @throws ApiExceptionInterface|RunetIdException
     */
    public function activateCoupon($coupon, $ownerOrItem, $product = null)
    {
        $builder = $this->client
            ->payCoupon()
            ->setPayerRunetId($this->payerRunetId)
            ->setCouponCode($coupon);

        if ($ownerOrItem instanceof ItemResult) {
            $builder
                ->setOwnerRunetId($ownerOrItem->Owner)
                ->setProductId($ownerOrItem->Product);
        } else {
            $builder->setOwnerRunetId($ownerOrItem);

            if (null !== $product) {
                $builder->setProductId($product);
            }
        }

        return $builder->getResult()->Discount;
    }

    /**
     * @throws ApiExceptionInterface|RunetIdException
     */
    public function reload()
    {
        $this->items = [];
        $this->orders = [];

        $payList = $this->client
            ->payList()
            ->setPayerRunetId($this->payerRunetId)
            ->getResult();

        foreach ($payList->Items as $item) {
            $this->items[$item->Id] = $item;
        }

        foreach ($payList->Orders as $order) {
            $this->orders[$order->OrderId] = $order;

            foreach ($order->Items as $item) {
                $this->items[$item->Id] = $item;
            }
        }
    }

    /**
     * @return string
     *
     * @throws ApiExceptionInterface|RunetIdException
     */
    public function getPaymentUrl()
    {
        return $this->client
            ->payUrl()
            ->setPayerRunetId($this->payerRunetId)
            ->getResult()
            ->Url;
    }
}
