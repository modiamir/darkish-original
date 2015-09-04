<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassifiedClassifiedTreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tree', 'entity', [
                'class' => 'Darkish\CategoryBundle\Entity\ClassifiedTree',
                'group_by' => 'parentTreeTitle',
                'property' => 'title',
                'query_builder' => function (\Doctrine\ORM\EntityRepository $repo) {
                    $qb = $repo->createQueryBuilder('ct');
                    $qb->andWhere('ct.upTreeIndex != :root')->setParameter('root', "00");

                    return $qb;
                },
                'label' => 'شاخه'
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree'
        ]);
    }

    public function getName()
    {
        return 'darkish_website_bundle_offer_offer_tree_type';
    }
}