<?php

namespace Darkish\WebsiteBundle\EventListener;

use Oneup\UploaderBundle\Event\PreUploadEvent;
use Oneup\UploaderBundle\Event\PostUploadEvent;
use Symfony\Component\DependencyInjection\Container;

class UploadListener
{
    public function __construct($doctrine, Container $container)
    {
        $this->doctrine = $doctrine;
        $this->container = $container;
    }

    public function preUpload(PreUploadEvent $event)
    {
        if(!$this->container->get('session')->isStarted())
        {
            $this->container->get('session')->start();
        }

    }

    public function postUpload(PostUploadEvent $event)
    {
        /* @var $file \Oneup\UploaderBundle\Uploader\File\FilesystemFile */
        $file = $event->getFile();
        $response = $event->getResponse();
        $responseFile = [];
        $responseFile['name'] = $file->getFilename();
        $responseFile['type'] = $file->getMimeType();
        $responseFile['size'] = $file->getSize();
        $responseFile['url'] = $file->getPath();


        $response['files'] = [$responseFile];

    }

}
