<?php
namespace Darkish\UserBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\UserBundle\Entity\Operator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager implements EventSubscriber
{
    protected $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function getEncoder(Operator $operator)
    {
        return $this->encoderFactory->getEncoder($operator);
    }
    
    public function getSubscribedEvents()
    {
        return array(
            'preUpdate',
            'prePersist',
        );
    }

    public function updateOperator(Operator $operator)
    {
        $newPassword = $operator->getNewPassword();
        if (!empty($newPassword)) {
            $encoder = $this->getEncoder($operator);
            $operator->setPassword($encoder->encodePassword($newPassword, $operator->getSalt()));
            
        }
    }
    
    public function preUpdate(PreUpdateEventArgs $event)
    {
        
        
        $operator = $event->getEntity();
        if (!($operator instanceof \Darkish\UserBundle\Entity\Operator)) {
            return;
        }


        
        $this->updateOperator($operator);
//        $event->setNewValue('password', $operator->getPassword());
    }
    
    public function prePersist(LifecycleEventArgs $event)
    {
        
        $operator = $event->getEntity();
        if (!($operator instanceof \Darkish\UserBundle\Entity\Operator)) {
            return;
        }

        $this->updateOperator($operator);
    }
    
    

}