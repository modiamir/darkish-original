<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Darkish\CategoryBundle\DarkishCategoryBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Darkish\PanelBundle\DarkishPanelBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Darkish\UserBundle\DarkishUserBundle(),
            new Darkish\CustomerBundle\DarkishCustomerBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Dubture\FFmpegBundle\DubtureFFmpegBundle(),
            new Oodle\KrumoBundle\OodleKrumoBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\CommentBundle\FOSCommentBundle(),
            new Darkish\CommentBundle\DarkishCommentBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new Pierrre\EncrypterBundle\PierrreEncrypterBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new Darkish\WebsiteBundle\DarkishWebsiteBundle(),
            new VMelnik\DoctrineEncryptBundle\VMelnikDoctrineEncryptBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new SymfonyPersia\JalaliDateBundle\SymfonyPersiaJalaliDateBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),

        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
//            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
