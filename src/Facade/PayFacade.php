<?php

namespace RunetId\ApiClient\Facade;

use RunetId\ApiClient\Model\Basket;
use RunetId\ApiClient\Model\Product;
use RunetId\ApiClient\Model\User;

/**
 * Class PayFacade
 */
class PayFacade extends BaseFacade
{
    /**
     * @param bool $onlyPublic
     * @return Product[]
     * @throws \RunetId\ApiClient\Exception\ResponseException
     */
    public function getProducts($onlyPublic = false)
    {
        $response = $this->apiClient->get('pay/products', array('OnlyPublic' => $onlyPublic));

        return $this->processResponse($response, 'product[]');
    }

    /**
     * Получает информацию о позициях в корзине и совершённых ранее заказах
     *
     * @param $payer
     * @return Basket
     * @throws \RunetId\ApiClient\Exception\ResponseException
     */
    public function getBasket($payer)
    {
        if ($payer instanceof User) {
            $payer = $payer->RunetId;
        }

        $data = $this->processResponse($this->apiClient->get('pay/list', [
            'PayerRunetId' => $payer
        ]));

        $basket = new Basket();
        $basket->setItems($this->modelReconstructor->reconstruct($data['Items'], 'order_item[]'));
        $basket->setOrders($this->modelReconstructor->reconstruct($data['Orders'], 'order[]'));

        return $basket;
    }

    /**
     * @deprecated Данный метод будет убран в версии 3.0. Переходим на использование getBasket()
     * @param User|int $payer
     * @return array
     * @throws \RunetId\ApiClient\Exception\ResponseException
     */
    public function getOrderItems($payer)
    {
        $basket = $this->getBasket($payer);

        return array(
            'Items' => $basket->getItems(),
            'Orders' => $basket->getOrders()
        );
    }

    /**
     * @param int   $productId
     * @param int   $payerRunetId
     * @param int   $ownerRunetId
     * @param array $attributes
     */
    public function addOrderItem($productId, $payerRunetId, $ownerRunetId, $attributes = array())
    {
        $response = $this->apiClient->post('pay/add', array(
            'ProductId' => $productId,
            'PayerRunetId' => $payerRunetId,
            'OwnerRunetId' => $ownerRunetId,
            'Attributes' => $attributes,
        ));

        $this->processResponse($response);
    }

    /**
     * @param int $orderItemId
     * @param int $productId
     * @param int $payerRunetId
     * @param int $ownerRunetId
     */
    public function editOrderItem($orderItemId, $productId, $payerRunetId, $ownerRunetId)
    {
        $response = $this->apiClient->post('pay/edit', array(
            'ProductId' => $productId,
            'OrderItemId' => $orderItemId,
            'PayerRunetId' => $payerRunetId,
            'OwnerRunetId' => $ownerRunetId
        ));

        $this->processResponse($response);
    }

    /**
     * @param int $orderItemId
     * @param int $payerRunetId
     */
    public function deleteOrderItem($orderItemId, $payerRunetId)
    {
        $response = $this->apiClient->post('pay/delete', array(
            'OrderItemId' => $orderItemId,
            'PayerRunetId' => $payerRunetId,
        ));

        $this->processResponse($response);
    }

    /**
     * @param int $payerRunetId
     * @return string
     */
    public function getUrl($payerRunetId)
    {
        $response = $this->apiClient->get('pay/url', array(
            'PayerRunetId' => $payerRunetId,
        ));

        $data = $this->processResponse($response);

        return $data['Url'];
    }

    /**
     * @param string $couponCode
     * @param int    $payerRunetId
     * @param int    $ownerRunetId
     */
    public function activateCoupon($couponCode, $payerRunetId, $ownerRunetId)
    {
        $response = $this->apiClient->post('pay/coupon', array(
            'CouponCode' => $couponCode,
            'PayerRunetId' => $payerRunetId,
            'OwnerRunetId' => $ownerRunetId,
        ));

        $this->processResponse($response);
    }
}
