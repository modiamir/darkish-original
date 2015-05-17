<?php

namespace Darkish\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstateType extends AbstractType
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
            
            ->add('estateFeatures')
            ->add('estateType', 'entity', array(
                'class' => 'DarkishCategoryBundle:EstateType',
                'property' => 'id'
                ))
            ->add('contractType', 'entity', array(
                'class' => 'DarkishCategoryBundle:ContractType',
                'property' => 'id'
                ))
            ->add('dimension')
            ->add('numOfRooms')
            ->add('floor')
            ->add('region')
            ->add('age')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Darkish\CategoryBundle\Entity\Estate'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'estate';
    }
}
