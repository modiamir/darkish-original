<?php

namespace Darkish\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsTreeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('upTreeIndex')
            ->add('treeIndex')
            ->add('sort')
            ->add('title')
            ->add('subTitle')
            ->add('backKeyTitle')
            ->add('searchKeywords')
            ->add('showSubtreeAsFilter')
            ->add('showSponsorBox')
            ->add('sponsorGroup')
            ->add('iconFileName')
            ->add('iconSetFilesName')
            ->add('fontColor')
            ->add('backColor')
            ->add('subPicShow')
            ->add('subBackground')
            ->add('subUnitHeightScale')
            ->add('hiddenTree')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CategoryBundle\Entity\NewsTree'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkish_categorybundle_newstree';
    }
}
