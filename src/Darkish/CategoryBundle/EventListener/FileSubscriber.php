<?php

namespace Darkish\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Alchemy\BinaryDriver\Listeners\DebugListener;
use Symfony\Component\HttpFoundation\File\File;




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
        // $this->videConvert($args);
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->index($args);
        // $this->videConvert($args);
    }
    
    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof ManagedFile && substr($entity->getFilemime(), 0, 5) == "image" && 
            file_exists($this->container->get('kernel')->getRootDir().'/../web/uploads/'.$entity->getWebPath())) {
            $request = $this->requestStack->getCurrentRequest();
            $cacheManager = $this->container->get('liip_imagine.cache.manager');

            // ... do something with the Product
            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        'web_thumb'              // filter defined in config.yml
            );
            
            

            // string to put directly in the "src" of the tag <img>
            
            $srcPath = $cacheManager->getBrowserPath('uploads/'.$entity->getWebPath(), 'web_thumb');
            
            $entity->setWebAbsolutePath($srcPath);



            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        'mobile_thumb'              // filter defined in config.yml
            );
            
            

            // string to put directly in the "src" of the tag <img>
            
            $srcPath = $cacheManager->getBrowserPath('uploads/'.$entity->getWebPath(), 'mobile_thumb');
            
            $entity->setMobileAbsolutePath($srcPath);
            

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        'icon_thumb'              // filter defined in config.yml
            );
            
            

            // string to put directly in the "src" of the tag <img>
            
            $srcPath = $cacheManager->getBrowserPath('uploads/'.$entity->getWebPath(), 'icon_thumb');
            
            $entity->setIconAbsolutePath($srcPath);            
        }  
    }

    public function videConvert(LifecycleEventArgs $args) {

        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof ManagedFile && substr($entity->getFilemime(), 0, 5) == "video") {
            $ffmpeg = $this->container->get('dubture_ffmpeg.ffmpeg');
            $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:ManagedFile');
            $video = $ffmpeg->open($entity->getUploadRootDir().'/'.$entity->getFileName());
            $video
                ->filters()
                ->resize(new Dimension(128, 72), ResizeFilter::RESIZEMODE_INSET)
                ->synchronize();

            // Start transcoding and save video
            if($video->save(new X264(), '/tmp/'.$entity->getPath())) {
                $file = new File('/tmp/'.$entity->getPath(), true);
                $file->move(
                    $entity->getUploadRootDir(),
                    $entity->getFileName()
                );
            } 
            // die($_SERVER['DOCUMENT_ROOT'].$this->container->get('request')->getBasePath()) ;

        }
    }
}