<?php

namespace Darkish\WebsiteBundle\Form;

use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('photos', 'collection', array(
                'type' => new ManagedFileType(),
                'allow_add' => true,
                'label' => 'تصاویر',
                'required'=>false
            ))
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