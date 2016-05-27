<?php

namespace RunetId\ApiClient;

use Ruvents\DataReconstructor\DataReconstructor;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ModelReconstructor
 */
class ModelReconstructor extends DataReconstructor
{
    /**
     * @inheritdoc
     */
    protected static $defaults = [
        'map' => [
            'user' => [
                'CreationTime' => 'DateTime',
                'Photo' => 'user_photo',
                'Work' => 'user_work',
                'Status' => 'user_status',
            ],
            'user_work' => [
                'Company' => 'user_work_company',
            ],
            'user_status' => [
                'UpdateTime' => 'DateTime',
            ],
            'section' => [
                'Start' => 'DateTime',
                'End' => 'DateTime',
                'UpdateTime' => 'DateTime',
                'Halls' => 'section_hall[]',
            ],
            'section_report' => [
                'User' => 'user',
                'UpdateTime' => 'DateTime',
            ],
        ],
        'model_classes' => [
            'error' => 'RunetId\ApiClient\Model\Error',
            'user' => 'RunetId\ApiClient\Model\User',
            'user_work_company' => 'RunetId\ApiClient\Model\User\Company',
            'user_photo' => 'RunetId\ApiClient\Model\User\Photo',
            'user_status' => 'RunetId\ApiClient\Model\User\Status',
            'user_work' => 'RunetId\ApiClient\Model\User\Work',
            'prof_interest' => 'RunetId\ApiClient\Model\ProfInterest',
            'event' => 'RunetId\ApiClient\Model\Event',
            'section' => 'RunetId\ApiClient\Model\Section',
            'section_hall' => 'RunetId\ApiClient\Model\Section\Hall',
            'section_report' => 'RunetId\ApiClient\Model\Section\Report',
        ],
    ];

    /**
     * @inheritdoc
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        /** @noinspection PhpUnusedParameterInspection */
        $resolver
            ->setAllowedTypes('model_classes', 'array')
            ->setNormalizer('model_classes', function (Options $options, $value) {
                return array_replace(static::$defaults['model_classes'], $value);
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
