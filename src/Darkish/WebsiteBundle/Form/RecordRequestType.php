<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecordRequestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', 'text' , ['label' => 'نام و نام خانوادگی'])
            ->add('phone', 'number', ['label' => 'شماره تماس'])
            ->add('unitName', 'text', ['label' => 'نام فروشکاه/موسسه'])
            ->add('email','email', ['label' => 'پست الکترونیکی'])
            ->add('captcha', 'captcha')
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CategoryBundle\Entity\RecordRequest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkish_categorybundle_recordrequest';
    }
}
