<?php

namespace Darkish\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('taskType')
            ->add('entityType')
            ->add('entityId')
            ->add('taskValue')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\UserBundle\Model\Task',
            'csrf_protection' => false,
        ));
    }

    public function getName()
    {
        return 'darkish_task';
    }
}
