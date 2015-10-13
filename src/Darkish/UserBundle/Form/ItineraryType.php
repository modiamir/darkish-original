<?php

namespace Darkish\UserBundle\Form;

use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ItineraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', null, [
                'label' => 'عنوان',
                'required' => true
            ])
            ->add('body', null, [
                'label' => 'متن',
                'required' => true
            ])
            ->add('fullName', null, [
                'label' => 'نام و نام خانوادگی',
                'required' => true
            ])
            ->add('photos', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\ManagedFile',
                'multiple' => true,
                'required' => false
            ])
//            ->add('photos', 'collection', array(
//                'type' => 'entity_hidden',
//                'options'  => array(
//                    'class'  => 'Darkish\CommentBundle\Entity\ManagedFile'
//                ),
//                'allow_add' => true,
//                'label' => 'تصاویر'
//            ))
//            ->add('captcha', 'captcha')
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CategoryBundle\Entity\Itinerary',
            'csrf_protection' => false,
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'itinerary_form';
    }
}