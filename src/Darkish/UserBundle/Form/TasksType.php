<?php

namespace Darkish\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TasksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tasks', 'collection', array(
            'type' => new TaskType(),
            'allow_add' => true,
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\UserBundle\Model\Tasks',
            'csrf_protection' => false,
            'cascade_validation' => true,
        ));
    }


    public function getName()
    {
        return 'darkish_tasks';
    }
}
