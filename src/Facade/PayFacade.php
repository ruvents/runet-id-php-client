<?php

namespace RunetId\ApiClient\Facade;

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
     */
    public function getProducts($onlyPublic = false)
    {
        $response = $this->apiClient->get('pay/products', array('OnlyPublic' => $onlyPublic));

        return $this->processResponse($response, 'product[]');
    }

    /**
     * @param User|int $payerRunetId
     * @return array
     */
    public function getOrderItems($payerRunetId)
    {
        if ($payerRunetId instanceof User) {
            $payerRunetId = $payerRunetId->RunetId;
        }

        $response = $this->apiClient->get('pay/list', array('PayerRunetId' => $payerRunetId));

        $data = $this->processResponse($response);

        $data['Items'] = $this->modelReconstructor->reconstruct($data['Items'], 'order_item[]');

        return $data;
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
