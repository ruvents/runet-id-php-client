<?php

namespace RunetId\ApiClient\Model;

use RunetId\ApiClient\Exception\InvalidArgumentException;

class Basket
{
    /**
     * Позиций заказа в корзине
     *
     * @var OrderItem[]
     */
    private $Items;

    /**
     * Ранее совершённые заказы
     *
     * @var Order[]
     */
    private $Orders;

    /**
     * Проверяет наличие товара в корзине и выставленных счетах
     *
     * @param $product int идентификатор продукта
     * @return bool
     */
    public function isProductExists($product)
    {
        if (!is_numeric($product)) {
            throw new InvalidArgumentException('The $runetId argument must be numeric.');
        }

        foreach ($this->Items as $item) {
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($item->Product->Id == $product) {
                return true;
            }
        }

        foreach ($this->Orders as $order) {
            foreach ($order->Items as $item) {
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($item->Product->Id == $product) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Проверяет наличие посетителя в корзине и выставленных счетах
     *
     * @param $person int RunetId посетителя
     * @return bool
     */
    public function isPersonExists($person)
    {
        if (!is_numeric($person)) {
            throw new InvalidArgumentException('The $runetId argument must be numeric.');
        }

        foreach ($this->Items as $item) {
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($item->Payer->RunetId == $person) {
                return true;
            }
            /** @noinspection TypeUnsafeComparisonInspection */
            if ($item->Owner->RunetId == $person) {
                return true;
            }
        }

        foreach ($this->Orders as $order) {
            foreach ($order->Items as $item) {
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($item->Payer->RunetId == $person) {
                    return true;
                }
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($item->Owner->RunetId == $person) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Возвращает статистику по находящимся в счетах посетителям
     *
     * @return array[]
     */
    public function getPersonsStat()
    {
        $result = array();

        foreach ($this->Items as $item) {
            if (isset($result[$item->Owner->RunetId]) === false) {
                $result[$item->Owner->RunetId] = [];
            }

            $result[$item->Owner->RunetId]['isCounted'] = true;
        }

        foreach ($this->Orders as $order) {
            foreach ($order->Items as $item) {
                if (isset($result[$item->Owner->RunetId]) === false) {
                    $result[$item->Owner->RunetId] = [];
                }

                /** @noinspection TypeUnsafeComparisonInspection */
                $result[$item->Owner->RunetId]['isPaidFor'] = $order->Paid;
                $result[$item->Owner->RunetId]['isOrdered'] = true;
            }
        }

        foreach ($result as $runetid => $stat) {
            if (isset($stat['isCounted']) === false) {
                $stat['isCounted'] = false;
            }
            if (isset($stat['isOrdered']) === false) {
                $stat['isOrdered'] = false;
            }
            if (isset($stat['isPaidFor']) === false) {
                $stat['isPaidFor'] = false;
            }
        }

        return $result;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems()
    {
        return $this->Items;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->Orders;
    }

    /**
     * @param OrderItem[] $Items
     */
    public function setItems($Items)
    {
        $this->Items = $Items;
    }

    /**
     * @param Order[] $Orders
     */
    public function setOrders($Orders)
    {
        $this->Orders = $Orders;
    }
}
