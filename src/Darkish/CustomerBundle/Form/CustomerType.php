<?php

namespace Darkish\CustomerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('newPassword')
            ->add('isActive')
            ->add('type')
            ->add('phoneOne')
            ->add('phoneTwo')
            ->add('phoneThree')
            ->add('phoneFour')
            ->add('fullName')
            ->add('photo', 'entity', array(
                'class' => 'DarkishCategoryBundle:ManagedFile',
                'property' => 'id',
            ))
            ->add('record', 'entity', array(
                'class' => 'DarkishCategoryBundle:Record',
                'property' => 'id',
            ))
            ->add('assistantAccess', 'entity', array(
                'class' => 'DarkishCustomerBundle:CustomerRole',
                'property' => 'id',
                'multiple' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Darkish\CustomerBundle\Entity\Customer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkish_customerbundle_customer';
    }
}
