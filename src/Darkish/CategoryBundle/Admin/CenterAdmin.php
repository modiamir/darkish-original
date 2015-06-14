<?php
// src/Acme/DemoBundle/Admin/PostAdmin.php

namespace Darkish\CategoryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CenterAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('subTitle')
            ->add('sort')
            ->add('centerType', 'sonata_type_model_list', array(
                ), array(
                    'placeholder' => 'No author selected',
                    'associated_property' => 'name'
                ))
            ->add('numOfFloors')
            ->add('numOfUnits')
            ->add('longitude')
            ->add('latitude')
            ->add('iconIndex')
            ->add('showBrands')
            ->add('showOffers')
            ->add('recordId')
            ->add('treeIndex')
            
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name')
            ->add('subTitle')
            ->add('sort')
            ->add('centerType')
            ->add('numOfFloors')
            ->add('numOfUnits')
            ->add('longitude')
            ->add('latitude')
            ->add('showBrands')
            ->add('showOffers')
            
            

        ;
    }
}
