<?php

namespace Darkish\CustomerBundle\EventListener;

use Darkish\CategoryBundle\Entity\Record;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CustomerBundle\Entity\Customer;
use Darkish\CustomerBundle\Entity\CustomerRole;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class CustomerSubscriber implements EventSubscriber
{
    
    protected $encoderFactory;
    
    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }
    
    public function getEncoder(Customer $customer)
    {
        return $this->encoderFactory->getEncoder($customer);
    }
    
    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'preUpdate',
            'prePersist',
            'preRemove',
        );
    }

    public function updateCustomer(Customer $customer)
    {
        $newPassword = $customer->getNewPassword();
        if (!empty($newPassword)) {
            $encoder = $this->getEncoder($customer);
            $customer->setPassword($encoder->encodePassword($newPassword, $customer->getSalt()));
            
        }

        if($customer->getRecord() instanceof Record)
        {
            $customer->setExpireDate($customer->getRecord()->getExpireDate());
            $customer->setRecordAccessLevel($customer->getRecord()->getAccessClass()->getId());
        }
    }
    
    public function preUpdate(LifecycleEventArgs $event)
    {
        
        
        $customer = $event->getEntity();
        if (!($customer instanceof Customer)) {
            return;
        }


        
        $this->updateCustomer($customer);
//        $event->setNewValue('password', $operator->getPassword());
    }
    
    public function prePersist(LifecycleEventArgs $event)
    {
        
        $customer = $event->getEntity();
        if (!($customer instanceof Customer)) {
            return;
        }
        $customer->setCreated(new \DateTime());
        $this->updateCustomer($customer);
    }
    
    
    
    public function postLoad(LifecycleEventArgs $args)
    {
        $this->index($args);
        $this->activeBasedOnRecord($args);
    }


    public function activeBasedOnRecord(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Customer) {
            
        }
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Customer) {
            // ... do something with the Product
            $role = new CustomerRole();
            $role->setName('مشتری');
            $role->setRole('ROLE_CUSTOMER');
            $entity->addRole($role);

            if($entity->getType() == 'owner') {
                /* @var $col \Doctrine\ORM\PersistentCollection */
                $record = $entity->getRecord();
                if($record) {
                    $col = $record->getAccessClass()->getCustomerRoles();

                    $entity->clearAssistantAccess();
                    foreach($col->toArray() as $value) {
                        $entity->addAssistantAccess($value);
                    }    
                }
                

                
            } else {
                $record = $entity->getRecord();
                if($record) {
                    /* @var $record \Darkish\CategoryBundle\Entity\Record */
                    $ral = $record->getAccessClass();
                    /* @var $ral \Darkish\CategoryBundle\Entity\RecordAccessLevel */
                    /* @var $col \Doctrine\ORM\PersistentCollection */
                    $col = $ral->getCustomerRoles();
                    
                    
                    $assistantAccess = $entity->getAssistantAccess();
                    $entity->clearAssistantAccess();
                    foreach($assistantAccess->toArray() as $value) {
                        if($col->contains($value)) {
                            $entity->addAssistantAccess($value);
                        }
                    }
                }
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if($entity instanceof Customer && $entity->getType() == 'assistant')
        {
            $record = $entity->getRecord();

            $owner = $entityManager
                        ->getRepository('DarkishCustomerBundle:Customer')
                        ->findOneBy([
                            'type' => 'owner',
                            'record' => $record->getId(),
                        ]);

//            die('='.$entity->getId());
            $query = $entityManager->createQuery("
                Update Darkish\CommentBundle\Entity\CustomerComment comment Set comment.owner = ".$owner->getId()." WHERE comment.owner = ".$entity->getId()." ");

//            die($query->getSQL());
            $query->execute();


            $query2 = $entityManager->createQuery("
                Update Darkish\CategoryBundle\Entity\Product product Set product.customer = ".$owner->getId()." WHERE product.customer = ".$entity->getId()." ");

//            die($query->getSQL());
            $query2->execute();





        }
    }
}