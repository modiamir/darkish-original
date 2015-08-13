<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstateSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractType', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\ContractType',
                'property' => 'value',
                'required' => false,

            ])
            ->add('estateType', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\EstateType',
                'property' => 'value',
                'required' => false,
            ])
            ->add('numOfRooms', 'choice', [
                'choices' => [1,2,3,4,5,6,7,8,9,10],
                'required' => false,
            ])
            ->add('dimension', 'number',[
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
            'data_class' => 'Darkish\CategoryBundle\Entity\Estate'
        ));
    }

    public function getName()
    {
        return 'estate_search';
    }
}