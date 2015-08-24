<?php

namespace Darkish\CustomerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerRecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('owner', null, ['required' => false])
            ->add('ownerMail', null, ['required' => false])
            ->add('ownerPhone', null, ['required' => false])
            ->add('manager', null, ['required' => false])
            ->add('managerMail', null, ['required' => false])
            ->add('managerPhone', null, ['required' => false])
            ->add('email', null, ['required' => false])
            ->add('telNumberOne', null, ['required' => false])
            ->add('telNumberTwo', null, ['required' => false])
            ->add('telNumberThree', null, ['required' => false])
            ->add('telNumberFour', null, ['required' => false])
            ->add('telNumberOneLabel', null, ['required' => false])
            ->add('telNumberTwoLabel', null, ['required' => false])
            ->add('telNumberThreeLabel', null, ['required' => false])
            ->add('telNumberFourLabel', null, ['required' => false])
            ->add('faxNumberOne', null, ['required' => false])
            ->add('faxNumberTwo', null, ['required' => false])
            ->add('mobileNumberOne', null, ['required' => false])
            ->add('mobileNumberTwo', null, ['required' => false])
            ->add('website', null, ['required' => false])
            ->add('smsNumber', null, ['required' => false])
            ->add('postalCode', null, ['required' => false])
            ->add('messageText', null, ['required' => false])
            ->add('sellServicePageCustomer', null, ['required' => false])
            ->add('dbaseEnableCustomer', null, ['required' => false])
            ->add('commentableCustomer', null, ['required' => false])
        ;


    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Darkish\CategoryBundle\Entity\Record'
        ));
    }

    public function getName()
    {
        return 'customer_record';
    }
}