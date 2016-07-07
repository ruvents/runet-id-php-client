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
        $response = $this->apiClient->get('pay/products', ['OnlyPublic' => $onlyPublic]);

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

        $response = $this->apiClient->get('pay/list', ['PayerRunetId' => $payerRunetId]);

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
    public function addOrderItem($productId, $payerRunetId, $ownerRunetId, $attributes = [])
    {
        $response = $this->apiClient->post('pay/add', [
            'ProductId' => $productId,
            'PayerRunetId' => $payerRunetId,
            'OwnerRunetId' => $ownerRunetId,
            'Attributes' => $attributes,
        ]);

        $this->processResponse($response);
    }

    /**
     * @param int $orderItemId
     * @param int $payerRunetId
     */
    public function deleteOrderItem($orderItemId, $payerRunetId)
    {
        $response = $this->apiClient->post('pay/delete', [
            'OrderItemId' => $orderItemId,
            'PayerRunetId' => $payerRunetId,
        ]);

        $this->processResponse($response);
    }

    /**
     * @param int $payerRunetId
     * @return string
     */
    public function getUrl($payerRunetId)
    {
        $response = $this->apiClient->get('pay/url', [
            'PayerRunetId' => $payerRunetId,
        ]);

        $data = $this->processResponse($response);

        return $data['Url'];
    }
}
