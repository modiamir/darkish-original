<?php

namespace Darkish\CategoryBundle\Imagine\Filter\Loader;

use Imagine\Filter\Basic\Thumbnail;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Container;
use Imagine\Image\Point;
use Imagine\Image\ImagineInterface;
use Imagine\Gd\Image;

class CustomWatermarkFilterLoader implements LoaderInterface
{
    private $container;
    private $imagine;
    private $rootPath;

    public function __construct(Container $container, ImagineInterface $imagine, $rootPath)
    {
        $this->container = $container;
        $this->imagine = $imagine;
        $this->rootPath = $rootPath;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ImageInterface $image, array $options = array())
    {
        foreach($options['watermarks'] as $watermarkOptions) {
            $image = $this->setThumbnail($image, $watermarkOptions);
        }

        return $image;
    }


    private function setThumbnail(ImageInterface $image, array $options = array())
    {
        $options += array(
            'size' => null,
            'position' => 'center',
        );

        if (substr($options['size'], -1) == '%') {
            $options['size'] = substr($options['size'], 0, -1) / 100;
        }

        $watermark = $this->imagine->open($this->rootPath.'/'.$options['image']);

        $size = $image->getSize();
        $watermarkSize = $watermark->getSize();

        // If 'null': Downscale if needed
        if (!$options['size'] && ($size->getWidth() < $watermarkSize->getWidth() || $size->getHeight() < $watermarkSize->getHeight())) {
            $options['size'] = 1.0;
        }

        if ($options['size']) {
            $factor = $options['size'] * min($size->getWidth() / $watermarkSize->getWidth(), $size->getHeight() / $watermarkSize->getHeight());

            $watermark->resize(new Box($watermarkSize->getWidth() * $factor, $watermarkSize->getHeight() * $factor));
            $watermarkSize = $watermark->getSize();
        }

        switch ($options['position']) {
            case 'topleft':
                $x = 0;
                $y = 0;
                break;
            case 'top':
                $x = ($size->getWidth() - $watermarkSize->getWidth()) / 2;
                $y = 0;
                break;
            case 'topright':
                $x = $size->getWidth() - $watermarkSize->getWidth();
                $y = 0;
                break;
            case 'left':
                $x = 0;
                $y = ($size->getHeight() - $watermarkSize->getHeight()) / 2;
                break;
            case 'center':
                $x = ($size->getWidth() - $watermarkSize->getWidth()) / 2;
                $y = ($size->getHeight() - $watermarkSize->getHeight()) / 2;
                break;
            case 'right':
                $x = $size->getWidth() - $watermarkSize->getWidth();
                $y = ($size->getHeight() - $watermarkSize->getHeight()) / 2;
                break;
            case 'bottomleft':
                $x = 0;
                $y = $size->getHeight() - $watermarkSize->getHeight();
                break;
            case 'bottom':
                $x = ($size->getWidth() - $watermarkSize->getWidth()) / 2;
                $y = $size->getHeight() - $watermarkSize->getHeight();
                break;
            case 'bottomright':
                $x = $size->getWidth() - $watermarkSize->getWidth();
                $y = $size->getHeight() - $watermarkSize->getHeight();
                break;
            default:
                throw new \InvalidArgumentException("Unexpected position '{$options['position']}'");
                break;
        }

        return $image->paste($watermark, new Point($x, $y));
    }
}
