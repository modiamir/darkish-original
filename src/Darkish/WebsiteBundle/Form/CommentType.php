<?php

namespace Darkish\WebsiteBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;



class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', null, ['label' => 'متن پاسخ'])
            ->add($builder->create('owner', new AnonymousType(), [
                'label' => 'مشخصات نویسنده پاسخ',
                'attr' => array('class' => 'anonymous-comment-form-owner'),
            ]))
            ->add('parent', 'entity_hidden', [
                'class' => 'Darkish\CommentBundle\Entity\Comment',
            ])
            ->add('captcha', 'captcha')
        ;


        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $comment = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$comment->getParent()) {
                $form->add('photos', 'collection', array(
                    'type' => new ManagedFileType(),
                    'allow_add' => true,
                    'label' => 'تصاویر'
                ));
            }
        });
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
