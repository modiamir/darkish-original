<?php

namespace Darkish\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class OperatorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('isActive')
            ->add('firstName')
            ->add('lastName')
            ->add('phone')
            ->add('mobile')
            ->add('secondaryMail')
            ->add('accessLevel')
            ->add('roles', 'entity', array(
                'class' => 'DarkishUserBundle:Role',
                'property' => 'id',
                'multiple' => true
            ))
            ->add('photo', 'entity', array(
                'class' => 'DarkishCategoryBundle:ManagedFile',
                'property' => 'id',
            ))
            ->add('creator')
        ;
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $product = $event->getData();
            $form = $event->getForm();
            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            $form->add('newPassword');
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Darkish\UserBundle\Entity\Operator'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkish_userbundle_operator';
    }
}
