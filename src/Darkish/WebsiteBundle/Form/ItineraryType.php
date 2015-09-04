<?php

namespace Darkish\WebsiteBundle\Form;

use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ItineraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title')
            ->add('body')
            ->add('photos', 'collection', array(
                'type' => new ManagedFileType(),
                'allow_add' => true,
            ))
        ;



    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Darkish\CategoryBundle\Entity\Itinerary'
        ));
    }

    public function getName()
    {
        return 'darkish_category_bundle_itinerary_form';
    }
}