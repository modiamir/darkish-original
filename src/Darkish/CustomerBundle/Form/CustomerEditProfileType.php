<?php

namespace Darkish\CustomerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerEditProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword')
            ->add('phoneOne')
            ->add('phoneTwo')
            ->add('phoneThree')
            ->add('phoneFour')
            ->add('fullName')
            ->add('photo', 'entity', array(
                'class' => 'DarkishCategoryBundle:ManagedFile',
                'property' => 'id',
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
        return 'customer_edit_profile';
    }
}
