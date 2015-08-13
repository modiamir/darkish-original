<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutomobileSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('automobileBrand', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\AutomobileBrand',
                'property' => 'value',
                'required' => false,

            ])
            ->add('automobileType', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\AutomobileType',
                'property' => 'value',
                'required' => false,
            ])
            ->add('createdYear', 'choice', [
                'choices' => [1,2,3,4,5,6,7,8,9,10],
                'required' => false,
            ])
            ->add('price', 'money',[
                'grouping'=> true,
                'currency'=>'IRR',
                'required' => false,
            ])

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CategoryBundle\Entity\Automobile'
        ));
    }

    public function getName()
    {
        return 'automobile_search';
    }
}