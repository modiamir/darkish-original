<?php

namespace Darkish\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutomobileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('secondaryPrice')

            ->add('createdYear')
            ->add('usage')
            ->add('tip')
            ->add('automobileFeatures')
            ->add('automobileColor', 'entity', array(
                'class' => 'DarkishCategoryBundle:AutomobileColor',
                'property' => 'id'
                ))
            ->add('automobileBrand', 'entity', array(
                'class' => 'DarkishCategoryBundle:AutomobileBrand',
                'property' => 'id'
                ))
            ->add('automobileType', 'entity', array(
                'class' => 'DarkishCategoryBundle:AutomobileType',
                'property' => 'id'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Darkish\CategoryBundle\Entity\Automobile'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'automobile';
    }
}
