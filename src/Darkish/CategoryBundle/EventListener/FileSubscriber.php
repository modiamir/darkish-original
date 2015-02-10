<?php

namespace Darkish\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;



class FileSubscriber implements EventSubscriber
{
    protected $container;
    protected $requestStack;
    
    public function __construct(ContainerInterface $container, RequestStack $requestStack) {
        $this->container = $container;
        $this->requestStack = $requestStack;
    }


    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'postPersist',
            'postUpdate',
        );
    }


    public function postLoad(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
    }
    
    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof ManagedFile && substr($entity->getFilemime(), 0, 5) == "image") {
            $request = $this->requestStack->getCurrentRequest();
            // ... do something with the Product
            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        'my_thumb'              // filter defined in config.yml
            );
            
            

            // string to put directly in the "src" of the tag <img>
            $cacheManager = $this->container->get('liip_imagine.cache.manager');
            $srcPath = $cacheManager->getBrowserPath('uploads/'.$entity->getWebPath(), 'my_thumb');
            
            $entity->setResizedAbsolutePath($srcPath);
            
        }
    }
}