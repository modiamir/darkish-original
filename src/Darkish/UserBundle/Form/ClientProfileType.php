<?php

namespace Darkish\UserBundle\Form;

use Darkish\WebsiteBundle\Form\ManagedFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class ClientProfileType extends AbstractType
{


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', null,[
                'required' => false
            ])
            ->add('photo', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\ManagedFile',
                'multiple' => false,
                'required' => false
            ])
        ;


        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {


            $data = $event->getData();
            $form = $event->getForm();


            if(!array_key_exists('fullName', $data)) {
                $form->remove('fullName');
            }

            if(!array_key_exists('photo', $data)) {

                $form->remove('photo');
            }


        });

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Darkish\UserBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkish_client';
    }
}
