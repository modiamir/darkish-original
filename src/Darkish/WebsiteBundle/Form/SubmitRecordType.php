<?php

namespace Darkish\WebsiteBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use libphonenumber\PhoneNumberFormat;



class SubmitRecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, [
                'label' => 'نام'
            ])
            ->add('lastName', null, [
                'label' => 'نام خانوادگی'
            ])
            ->add('phone', 'tel', [
                'label' => 'تلفن ثابت',
                'default_region' => 'IR',
                'format' => PhoneNumberFormat::NATIONAL,
                'invalid_message' => 'تلفن وارد شده معتبر نمیباشد'
            ])
            ->add('mobile', 'tel', [
                'label' => 'تلفن همراه',
                'default_region' => 'IR',
                'format' => PhoneNumberFormat::NATIONAL,
                'invalid_message' => 'تلفن وارد شده معتبر نمیباشد'

            ])
            ->add('title', null, [
                'label' => 'عنوان'
            ])
            ->add('description', null, [
                'label' => 'توضیح نوع فعالیت'
            ])
            ->add('email', null, [
                'label' => 'پست الکترونیک',
                'required' => false
            ])
            ->add('licenseNumber', null, [
                'label' => 'شماره مجوز فعالیت',
                'required' => false
            ])
            ->add('companyName', null, [
                'label' => 'نام شرکت',
                'required' => false
            ])
            ->add('companyRegNumber', null, [
                'label' => 'شماره ثبت شرکت',
                'required' => false
            ])
            ->add('companyRegDate', 'text', [
                'label' => 'تاریخ ثبت شرکت',
                'required' => false
            ])
            ->add('captcha', 'captcha')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => 'Darkish\CategoryBundle\Entity\SubmitRecord'
            ]);
    }

    public function getName()
    {
        return 'submit_record_type';
    }
}