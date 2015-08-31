<?php

namespace Darkish\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
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
            ->add('specialText')
            ->add('description')
            ->add('price', null, ['required' => true])
            ->add('discountedPrice')
            ->add('sort')
            ->add('availability','integer', array(
                    'data'=>1
                ))
            ->add('specialTag', 'integer', array(
                    'data'=>1
                ))
            ->add('group', 'entity', array(
                'class' => 'DarkishCategoryBundle:StoreGroup',
                'property' => 'id',  
                ))
            ->add('photos', 'entity', array(
                'class' => 'DarkishCategoryBundle:ManagedFile',
                'property' => 'id',
                'multiple' => true
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
            'data_class' => 'Darkish\CategoryBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'product';
    }
}
