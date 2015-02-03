<?php

namespace Darkish\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class OperatorType extends AbstractType
{
    
    private $tokenStorage;
    
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
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
        
        // grab the user, do a quick sanity check that one exists
        $user = $this->tokenStorage->getToken()->getUser();
        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }
        
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
