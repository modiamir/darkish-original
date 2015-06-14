<?php
// src/Acme/DemoBundle/Admin/PostAdmin.php

namespace Darkish\CategoryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RecordRequestAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('fullName', 'text', array('label' => 'Full Name'))
            ->add('phone', 'number', array('label' => 'Phone'))
            ->add('unitName', 'text', array('label' => 'Unit Name'))
            ->add('email', 'text', array('label' => 'E-mail'))
            ->add('description')
            ->add('status')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fullName')
            ->add('unitName')
            ->add('status')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullName')
            ->add('phone')
            ->add('unitName')
            ->add('email')
            ->add('created')
            ->add('status')

        ;
    }
}
