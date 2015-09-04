<?php

namespace Darkish\WebsiteBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EstateSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('record', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\Record',
                'property' => 'title',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
                'label' => 'آژانس',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.dbaseEnable = :dbe')->setParameter('dbe', true)
                        ->andWhere('r.dbaseTypeIndex = :dbt')->setParameter('dbt', 1);
                }
            ])
            ->add('contractType', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\ContractType',
                'property' => 'value',
                'required' => false,
                'label' => 'نوع قرارداد'
            ])
            ->add('estateType', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\EstateType',
                'property' => 'value',
                'required' => false,
                'label' => 'نوع ملک'
            ])
            ->add('numOfRooms', 'choice', [
                'choices' => [1=>1,2=>2,3=>3,4=>4, 1000 => 'پنج یا بیشتر'],
                'required' => false,
                'label' => 'تعداد اتاق'
            ])
            ->add('dimension', 'number',[
                'required' => false,
                'label' => 'متراژ'
            ])
            ->add('price', 'text',[
                'required' => false,
            ])
            ->add('secondaryPrice', 'text',[
                'required' => false,
                'label' => 'اجاره'
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