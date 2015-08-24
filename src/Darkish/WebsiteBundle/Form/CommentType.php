<?php

namespace Darkish\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($builder->create('owner', new AnonymousType()))
            ->add('body')
            ->add('parent', 'entity_hidden', [
                'class' => 'Darkish\CommentBundle\Entity\Comment',
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CommentBundle\Entity\AnonymousComment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'submit_anonymous_comment';
    }
}