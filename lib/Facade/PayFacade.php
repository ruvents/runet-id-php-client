<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Common\ArgHelper;
use RunetId\ApiClient\Model\Pay\Item;
use RunetId\ApiClient\Model\Pay\ItemIdInterface;
use RunetId\ApiClient\Model\Pay\ItemList;
use RunetId\ApiClient\Model\Pay\Product;
use RunetId\ApiClient\Model\Pay\ProductIdInterface;
use RunetId\ApiClient\Model\User\UserRunetIdInterface;

class PayFacade extends AbstractFacade
{
    /**
     * @param string                      $code
     * @param int|UserRunetIdInterface    $payerId
     * @param int|UserRunetIdInterface    $ownerId
     * @param null|int|ProductIdInterface $productId
     * @param array                       $context
     *
     * @return array
     */
    public function activatePromoCode($code, $payerId, $ownerId, $productId = null, array $context = [])
    {
        return $this->requestPost($context, '/pay/coupon', array_filter([
            'CouponCode' => $code,
            'PayerRunetId' => ArgHelper::getUserRunetId($payerId),
            'OwnerRunetId' => ArgHelper::getUserRunetId($ownerId),
            'ProductId' => ArgHelper::getProductId($productId),
        ]));
    }

    /**
     * @param int|UserRunetIdInterface $payerId
     * @param int|UserRunetIdInterface $ownerId
     * @param int|ProductIdInterface   $productId
     * @param array                    $context
     *
     * @return void
     */
    public function addItem($payerId, $ownerId, $productId, array $context = [])
    {
        $this->requestPost($context, '/pay/add', [
            'PayerRunetId' => ArgHelper::getUserRunetId($payerId),
            'OwnerRunetId' => ArgHelper::getUserRunetId($ownerId),
            'ProductId' => ArgHelper::getProductId($productId),
        ]);
    }

    /**
     * @param int|ItemIdInterface|Item      $itemId
     * @param null|int|UserRunetIdInterface $payerId
     * @param array                         $context
     *
     * @return void
     */
    public function deleteItem($itemId, $payerId = null, array $context = [])
    {
        if ($itemId instanceof Item) {
            $payerId = $payerId ?: $itemId->getPayer()->getRunetId();
        }

        $this->requestPost($context, '/pay/delete', [
            'OrderItemId' => ArgHelper::getPayItemId($itemId),
            'PayerRunetId' => ArgHelper::getUserRunetId($payerId),
        ]);
    }

    /**
     * @param int|ItemIdInterface           $itemId
     * @param null|int|UserRunetIdInterface $payerId
     * @param null|int|UserRunetIdInterface $ownerId
     * @param null|int|ProductIdInterface   $productId
     * @param array                         $context
     *
     * @return void
     */
    public function editItem($itemId, $payerId, $ownerId, $productId, array $context = [])
    {
        $this->requestPost($context, '/pay/edit', [
            'OrderItemId' => ArgHelper::getPayItemId($itemId),
            'PayerRunetId' => ArgHelper::getUserRunetId($payerId),
            'OwnerRunetId' => ArgHelper::getUserRunetId($ownerId),
            'ProductId' => ArgHelper::getProductId($productId),
        ]);
    }

    /**
     * @param int|UserRunetIdInterface $payerId
     * @param array                    $context
     *
     * @return array|ItemList
     */
    public function getItemList($payerId, array $context = [])
    {
        return $this->requestGet($context, '/pay/list', [
            'PayerRunetId' => ArgHelper::getUserRunetId($payerId),
        ]);
    }

    /**
     * @param array $context
     *
     * @return array|Product[]
     */
    public function getProducts(array $context = [])
    {
        return $this->requestGet($context, '/pay/products');
    }

    /**
     * @param int|UserRunetIdInterface $payerId
     * @param array                    $context
     *
     * @return string
     */
    public function getUrl($payerId, array $context = [])
    {
        return $this->requestGet($context, '/pay/url', [
            'PayerRunetId' => ArgHelper::getUserRunetId($payerId),
        ]);
    }
}
