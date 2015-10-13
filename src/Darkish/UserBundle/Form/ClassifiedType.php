<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassifiedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('classifiedtrees', 'collection', array(
                'type' => new ClassifiedClassifiedTreeType(),
                'label' => 'انتخاب شاخه'
            ))
            ->add('title', null, [
                'label' => 'عنوان'
            ])
            ->add('address', null, [
                'label' => 'آدرس'
            ])
            ->add('body', null, [
                'label' => 'توضیحات'
            ])
            ->add('telNumberOne', null, [
                'label' => 'تلفن'
            ])
            ->add('telNumberTwo', null, [
                'label' => 'تلفن'
            ])
            ->add('telNumberThree', null, [
                'label' => 'تلفن'
            ])
            ->add('telNumberFour', null, [
                'label' => 'تلفن'
            ])
            ->add('faxNumberOne', null, [
                'label' => 'فکس'
            ])
            ->add('faxNumberTwo', null, [
                'label' => 'فکس'
            ])
            ->add('mobileNumberOne', null, [
                'label' => 'تلفن همراه'
            ])
            ->add('mobileNumberTwo', null, [
                'label' => 'تلفن همراه'
            ])
            ->add('email', null, [
                'label' => 'پست الکترونیک'
            ])
            ->add('website', null, [
                'label' => 'وبسایت'
            ])
            ->add('price', null, [
                'label' => 'قیمت'
            ])

            ->add('images', 'entity', array(
                'class' => 'Darkish\CategoryBundle\Entity\ManagedFile',
                'multiple' => true,
                'required' => false
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Darkish\CategoryBundle\Entity\Classified'
        ]);
    }

    public function getName()
    {
        return 'darkish_classified';
    }
}