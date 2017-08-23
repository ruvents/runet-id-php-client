<?php

namespace RunetId\ApiClient\PropertyInfo;

use RunetId\ApiClient\Model\Common;
use RunetId\ApiClient\Model\Company;
use RunetId\ApiClient\Model\Event;
use RunetId\ApiClient\Model\Pay;
use RunetId\ApiClient\Model\User;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

class ModelTypeExtractor implements PropertyTypeExtractorInterface
{
    /**
     * @var null|array
     */
    private $types;

    /**
     * {@inheritdoc}
     */
    public function getTypes($class, $property, array $context = [])
    {
        if (null === $this->types) {
            $this->types = $this->loadTypes();
        }

        return isset($this->types[$class][$property]) ? $this->types[$class][$property] : null;
    }

    /**
     * @return Type[][]
     */
    protected function loadTypes()
    {
        $company = new Type(Type::BUILTIN_TYPE_OBJECT, true, Company\Company::className());
        $dateTime = new Type(Type::BUILTIN_TYPE_OBJECT, true, 'DateTimeImmutable');
        $geoPoint = new Type(Type::BUILTIN_TYPE_OBJECT, true, Common\GeoPoint::className());
        $items = new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true, null, new Type(Type::BUILTIN_TYPE_OBJECT, false, Pay\Item::className()));
        $orders = new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true, null, new Type(Type::BUILTIN_TYPE_OBJECT, false, Pay\Order::className()));
        $participation = new Type(Type::BUILTIN_TYPE_OBJECT, true, Event\Participation::className());
        $product = new Type(Type::BUILTIN_TYPE_OBJECT, true, Pay\Product::className());
        $status = new Type(Type::BUILTIN_TYPE_OBJECT, true, Event\Status::className());
        $user = new Type(Type::BUILTIN_TYPE_OBJECT, true, User\User::className());
        $work = new Type(Type::BUILTIN_TYPE_OBJECT, true, User\Work::className());

        return $this->types = [
            Event\Event::className() => [
                'end' => [$dateTime],
                'geoPoint' => [$geoPoint],
                'start' => [$dateTime],
            ],
            Event\Participation::className() => [
                'status' => [$status],
                'updatedAt' => [$dateTime],
            ],
            Pay\Item::className() => [
                'createdAt' => [$dateTime],
                'owner' => [$user],
                'paidAt' => [$dateTime],
                'payer' => [$user],
                'product' => [$product],
            ],
            Pay\ItemList::className() => [
                'nonOrderedItems' => [$items],
                'orders' => [$orders],
            ],
            Pay\Order::className() => [
                'createdAt' => [$dateTime],
                'items' => [$items],
            ],
            Pay\Product::className() => [
                'priceEnd' => [$dateTime],
                'priceStart' => [$dateTime],
            ],
            User\User::className() => [
                'createdAt' => [$dateTime],
                'participation' => [$participation],
                'work' => [$work],
            ],
            User\Work::className() => [
                'company' => [$company],
            ],
        ];
    }
}
