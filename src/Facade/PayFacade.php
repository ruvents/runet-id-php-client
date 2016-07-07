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
}
