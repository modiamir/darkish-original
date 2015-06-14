<?php
// src/Acme/DemoBundle/Admin/PostAdmin.php

namespace Darkish\CategoryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RecordAccessLevelAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('customerRoles')
            ->add('bodyImagesLimit')
            ->add('bodyVideosLimit')
            ->add('bodyAudiosLimit')
            ->add('bodyDocsLimit')
            ->add('attachmentImagesLimit')
            ->add('attachmentVideosLimit')
            ->add('groupMessageInterval')
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
            

        ;
    }
}
