<?php

namespace Darkish\CategoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subTitle')
            ->add('createdDate')
            ->add('publishDate')
            ->add('expireDate')
            ->add('body')
            ->add('userId')
            ->add('status')
            ->add('isCompetition')
            ->add('trueAnswer')
            ->add('rate')
            ->add('category')
            ->add('newstreeId')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CategoryBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'darkish_categorybundle_news';
    }
}
