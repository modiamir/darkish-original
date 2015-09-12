<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnonymousType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', null , ['label' => 'نام'])
            ->add('email', 'email', ['label' => '
            پست الکترونیک (پست الکترونیک شما نمایش داده نخواهد شد. جهت پیگیری های بعدی حتما آن را وارد کنید.)
            '])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\UserBundle\Entity\Anonymous'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anonymous';
    }
}
