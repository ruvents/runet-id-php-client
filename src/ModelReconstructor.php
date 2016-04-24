<?php

namespace RunetId\ApiClient;

use Ruvents\DataReconstructor\DataReconstructor;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ModelReconstructor
 */
class ModelReconstructor extends DataReconstructor
{
    /**
     * @inheritdoc
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
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
            ])
            ->setAllowedTypes('model_classes', 'array');
    }

    /**
     * @inheritdoc
     */
    protected function reconstructObject($data, $className, array $map)
    {
        $realClassName = $this->replaceModelClass($className);

        switch ($className) {
            case 'DateTime':
                $object = new \DateTime($data);
                break;

            default:
                $object = parent::reconstructObject($data, $realClassName, $map);
        }

        return $object;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function replaceModelClass($name)
    {
        $cleanName = $name;
        $isArray = false;

        if (substr($name, -2) === '[]') {
            $cleanName = substr($name, 0, -2);
            $isArray = true;
        }

        if (isset($this->options['model_classes'][$cleanName])) {
            return $this->options['model_classes'][$name].($isArray ? '[]' : '');
        }

        return $name;
    }
}
