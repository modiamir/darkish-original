<?php

namespace Darkish\WebsiteBundle\EventListener;

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


    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
        );
    }



}