<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ManagedFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('uploadDir', 'hidden')
//            ->add('type', 'hidden')
            ->add('fileName', 'hidden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Darkish\CategoryBundle\Entity\ManagedFile',
            'csrf_protection'=> false
        ]);
    }

    public function getName()
    {
        return 'managedfile_type';
    }
}