<?php

namespace Darkish\CustomerBundle\EventListener;

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
        );
    }

    public function updateCustomer(Customer $customer)
    {
        $newPassword = $customer->getNewPassword();
        if (!empty($newPassword)) {
            $encoder = $this->getEncoder($customer);
            $customer->setPassword($encoder->encodePassword($newPassword, $customer->getSalt()));
            
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
}