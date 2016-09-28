<?php

namespace RunetId\ApiClient;

use Ruvents\DataReconstructor\DataReconstructor;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelReconstructor extends DataReconstructor
{
    /**
     * @inheritdoc
     */
    protected static $defaults = array(
        'map' => array(
            'user' => array(
                'CreationTime' => 'DateTime',
                'Photo' => 'user_photo',
                'Work' => 'user_work',
                'Status' => 'user_status',
            ),
            'user_work' => array(
                'Company' => 'user_work_company',
            ),
            'user_status' => array(
                'UpdateTime' => 'DateTime',
            ),
            'section' => array(
                'Start' => 'DateTime',
                'End' => 'DateTime',
                'UpdateTime' => 'DateTime',
                'Halls' => 'section_hall[]',
            ),
            'section_report' => array(
                'User' => 'user',
                'UpdateTime' => 'DateTime',
            ),
            'section_favorite' => array(
                'UpdateTime' => 'DateTime',
            ),
            'order_item' => array(
                'Product' => 'product',
                'Payer' => 'user',
                'Owner' => 'user',
                'PaidTime' => 'DateTime',
                'CreationTime' => 'DateTime',
            ),
            'order' => array(
                'CreationTime' => 'DateTime',
                'Items' => 'order_item[]',
            ),
            'basket' => array(
                'Items' => 'order_item[]',
                'Orders' => 'order[]',
            ),
            'connection' => array(
                'Place' => 'connection_place',
                'Creator' => 'user',
                'Users' => 'connection_response[]',
                'Date' => 'DateTime',
                'CreateTime' => 'DateTime',
            ),
            'connection_response' => array(
                'User' => 'user',
            ),
        ),
        'model_classes' => array(
            'error' => 'RunetId\ApiClient\Model\Error',
            'user' => 'RunetId\ApiClient\Model\User',
            'user_work_company' => 'RunetId\ApiClient\Model\User\Company',
            'user_photo' => 'RunetId\ApiClient\Model\User\Photo',
            'user_status' => 'RunetId\ApiClient\Model\User\Status',
            'user_work' => 'RunetId\ApiClient\Model\User\Work',
            'prof_interest' => 'RunetId\ApiClient\Model\ProfInterest',
            'event' => 'RunetId\ApiClient\Model\Event',
            'event_role' => 'RunetId\ApiClient\Model\EventRole',
            'section' => 'RunetId\ApiClient\Model\Section',
            'section_hall' => 'RunetId\ApiClient\Model\Section\Hall',
            'section_report' => 'RunetId\ApiClient\Model\Section\Report',
            'section_favorite' => 'RunetId\ApiClient\Model\Section\Favorite',
            'product' => 'RunetId\ApiClient\Model\Product',
            'order' => 'RunetId\ApiClient\Model\Order',
            'order_item' => 'RunetId\ApiClient\Model\OrderItem',
            'basket' => 'RunetId\ApiClient\Model\Basket',
            'connection' => 'RunetId\ApiClient\Model\Connection',
            'connection_place' => 'RunetId\ApiClient\Model\Connection\Place',
            'connection_response' => 'RunetId\ApiClient\Model\Connection\Response',
        ),
    );

    /**
     * @inheritdoc
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $defModelClasses = static::$defaults['model_classes'];

        /** @noinspection PhpUnusedParameterInspection */
        $resolver
            ->setAllowedTypes('model_classes', 'array')
            ->setNormalizer('model_classes', function (Options $options, $value) use ($defModelClasses) {
                return array_replace($defModelClasses, $value);
            });
    }

    /**
     * @inheritdoc
     */
    protected function createObject($className, &$data, array $map)
    {
        $className = $this->getRealClassName($className);

        return parent::createObject($className, $data, $map);
    }

    /**
     * @param string $className
     * @return string
     */
    protected function getRealClassName($className)
    {
        $isArray = false;

        if (substr($className, -2) === '[]') {
            $className = substr($className, 0, -2);
            $isArray = true;
        }

        if (isset($this->options['model_classes'][$className])) {
            $className = $this->options['model_classes'][$className];
        }

        return $className.($isArray ? '[]' : '');
    }
}
