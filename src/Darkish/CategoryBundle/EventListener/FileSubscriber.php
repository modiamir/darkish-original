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
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Media\Video;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class FileSubscriber implements EventSubscriber
{
    protected $container;
    protected $requestStack;
    protected $darkishWatermark;
    protected $watermarks = [
        'darkish' => [
            'image' => 'Resources/data/watermark.png',
            'position' => 'topright',
        ],
        'island' => [
            'image' => 'Resources/data/watermark.png',
            'position' => 'bottomright',
        ],
        'aruna' => [
            'image' => 'Resources/data/watermark.png',
            'position' => 'bottomleft',
        ],
        'label' => [
            'image' => 'Resources/data/watermark.png',
            'position' => 'topleft',
        ],
    ];
    
    public function __construct(ContainerInterface $container, RequestStack $requestStack, $darkishWatermark) {
        $this->container = $container;
        $this->requestStack = $requestStack;
        $this->darkishWatermark = $darkishWatermark;
    }


    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'postPersist',
            'postUpdate',
            'prePersist',
        );
    }



    public function postLoad(LifecycleEventArgs $args)
    {
        $this->runImageFilters($args, false);
//        $this->index($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->runImageFilters($args, false);
//        $this->index($args);
        // $this->videConvert($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->getFrameFromVideo($args);
        // $this->videConvert($args);
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->runImageFilters($args, true);
//        $this->index($args);
        // $this->videConvert($args);
    }

    public function runImageFilters(LifecycleEventArgs $args, $force = false) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof ManagedFile && substr($entity->getFilemime(), 0, 5) == "image" &&
            file_exists($this->container->get('kernel')->getRootDir().'/../web/uploads/'.$entity->getWebPath())) {


            $path = 'uploads/'.$entity->getWebPath();

            /**
             * Generating web_thumb Filter
             */
            $filter = "web_thumb";
            $srcPath = $this->runFilter($path, $filter, $entity, $force, '50%');
            $entity->setWebAbsolutePath($srcPath);

            /**
             * Generating mobile_thumb Filter
             */
            $filter = "mobile_thumb";
            $srcPath = $this->runFilter($path, $filter, $entity, $force, '30%');
            $entity->setMobileAbsolutePath($srcPath);

            /**
             * Generating mobile_thumb Filter
             */
            $filter = "icon_thumb";
            $srcPath = $this->runFilter($path, $filter, $entity, $force, '20%');
            $entity->setIconAbsolutePath($srcPath);

            /**
             * Generating 64 Filter
             */
            $filter = "64";
            $srcPath = $this->runFilter($path, $filter, $entity, $force);

            /**
             * Generating 128 Filter
             */
            $filter = "128";
            $srcPath = $this->runFilter($path, $filter, $entity, $force);

            /**
             * Generating 256 Filter
             */
            $filter = "256";
            $srcPath = $this->runFilter($path, $filter, $entity, $force, '10%');

            /**
             * Generating 64 Filter
             */
            $filter = "512";
            $srcPath = $this->runFilter($path, $filter, $entity, $force, '10%');

            /**
             * Generating 1024 Filter
             */
            $filter = "1024";
            $srcPath = $this->runFilter($path, $filter, $entity, $force, '10%');
        }
    }

    private function runFilter($path, $filter, ManagedFile $entity, $force, $watermarkSize = null)
    {


        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $dataManager = $this->container->get('liip_imagine.data.manager');
        $filterManager = $this->container->get('liip_imagine.filter.manager');
        $watermarks = [];

        if(
            (in_array($entity->getType() , ['record', 'news']) && $entity->getDarkishWatermark() ) ||
            (!in_array($entity->getType() , ['record', 'news']) && $this->darkishWatermark[$entity->getType()] == true)
        )
        {
            if($watermarkSize)
            {
                $tempWatermark = $this->watermarks['darkish'];
                $tempWatermark['size'] = $watermarkSize;
                $watermarks[] = $tempWatermark;
            }
        }

        if(in_array($entity->getType() , ['record', 'news']) && $entity->getIslandWatermark() && $watermarkSize)
        {
            $tempWatermark = $this->watermarks['island'];
            $tempWatermark['size'] = $watermarkSize;
            $watermarks[] = $tempWatermark;
        }

        if(in_array($entity->getType() , ['record', 'news']) && $entity->getArunaWatermark() && $watermarkSize)
        {
            $tempWatermark = $this->watermarks['aruna'];
            $tempWatermark['size'] = $watermarkSize;
            $watermarks[] = $tempWatermark;
        }

        if(in_array($entity->getType() , ['database', 'product', 'classified']) && $watermarkSize)
        {
            $tempWatermark = $this->watermarks['label'];
            $tempWatermark['size'] = $watermarkSize;
            $watermarks[] = $tempWatermark;
        }

        if($force || !$cacheManager->isStored($path, $filter)) {
            $binary = $dataManager->find($filter, $path);

            $filteredBinary = $filterManager->applyFilter($binary, $filter, array(
                'filters' => array(
                    'custom_watermark' => array(
                        'watermarks' => $watermarks
                    )
                )
            ));

            $cacheManager->store($filteredBinary, $path, $filter);
        }

        return $cacheManager->getBrowserPath($path, $filter);

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
            

            //generate 64px width image

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        '64'              // filter defined in config.yml
            );
            

            //generate 128px width image

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        '128'              // filter defined in config.yml
            );
            
            //generate 256px width image

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        '256'              // filter defined in config.yml
            );
            

            //generate 512px width image

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        '512'              // filter defined in config.yml
            );
            

            //generate 1024px width image

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                    ->filterAction(
                        $request,          // http request
                        'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                        '1024'              // filter defined in config.yml
            );


            //generate 64px width image without thumbnail

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,          // http request
                    'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                    '64n'              // filter defined in config.yml
                );


            //generate 128px width image without thumbnail

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,          // http request
                    'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                    '128n'              // filter defined in config.yml
                );

            //generate 256px width image without thumbnail

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,          // http request
                    'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                    '256n'              // filter defined in config.yml
                );


            //generate 512px width image without thumbnail

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,          // http request
                    'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                    '512n'              // filter defined in config.yml
                );


            //generate 1024px width image without thumbnail

            $imagemanagerResponse = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,          // http request
                    'uploads/'.$entity->getWebPath(),      // original image you want to apply a filter to
                    '1024n'              // filter defined in config.yml
                );

            // string to put directly in the "src" of the tag <img>
            
            $srcPath = $cacheManager->getBrowserPath('uploads/'.$entity->getWebPath(), 'icon_thumb');
            
            $entity->setIconAbsolutePath($srcPath);            
        }  
    }


    public function getFrameFromVideo(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof ManagedFile && substr($entity->getFilemime(), 0, 5) == "video") {
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($this->container->get( 'kernel' )->getRootDir(). '/../web/uploads/video/'.$entity->getFileName());
            $thumbName = substr($entity->getFileName(), 0, strrpos($entity->getFileName(), '.')).'.jpg';
            $video
                ->frame(TimeCode::fromSeconds(10))
                ->save($this->container->get( 'kernel' )->getRootDir(). '/../web/uploads/video_thumbnail/'.$thumbName);
            $entity->setVideoThumbnail($thumbName);
            // $file = new File('/tmp/'.$thumbName);
            // $file->move($this->container->get( 'kernel' )->getRootDir(). '/../web/uploads/video_thumbnail');
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
            

        }
    }
}