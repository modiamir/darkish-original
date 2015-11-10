<?php

namespace Darkish\WebsiteBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutomobileSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = [];
        $date = new \DateTime();
        for($i = (int)$date->format("Y") - 10 ; $i <= (int)$date->format("Y") + 1; $i++)
        {
            $years[] = $i;
        }

        $builder
            ->add('record', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\Record',
                'choice_label' => 'title',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
                'label' => 'نمایشگاه',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.dbaseEnable = :dbe')->setParameter('dbe', true)
                        ->andWhere('r.dbaseTypeIndex = :dbt')->setParameter('dbt', 2);
                }
            ])
            ->add('automobileBrand', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\AutomobileBrand',
                'choice_label' => 'value',
                'required' => false,
                'label' => 'برند'

            ])
            ->add('automobileColor', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\AutomobileColor',
                'choice_label' => 'value',
                'required' => false,
                'label' => 'رنگ'
            ])
            ->add('automobileType', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\AutomobileType',
                'choice_label' => 'value',
                'required' => false,
                'label' => 'نوع'
            ])
            ->add('createdYear', 'choice', [
                'choices' => $years,
                'required' => false,
                'label' => 'سال ساخت'
            ])
            ->add('price', 'text',[
                'required' => false,
                'label' => 'قیمت'
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