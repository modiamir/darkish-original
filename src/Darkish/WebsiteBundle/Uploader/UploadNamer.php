<?php

namespace Darkish\WebsiteBundle\Uploader;

use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class UploadNamer implements NamerInterface
{
    private $container;
    private $request;

    public function  __construct(Container $container)
    {
        $this->container = $container;
        $this->request = $container->get('request');
    }

    public function name(FileInterface $file)
    {
        $type = ($this->request->request->has('type'))? $this->request->get('type') : 'file';
        $fileName = $type.'-'.time().'-'.rand(10000, 99999).'.'.$file->getExtension();

        return $fileName;
    }
}
