<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\ZendBundle\ZendBundle(),
            new Symfony\Bundle\DoctrineMongoDBBundle\DoctrineMongoDBBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),

            new FOS\UserBundle\FOSUserBundle(),
            new FOS\CommentBundle\FOSCommentBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            new Ltc\UserBundle\LtcUserBundle(),
            new Ltc\CoreBundle\LtcCoreBundle(),
            new Ltc\DocBundle\LtcDocBundle(),
            new Ltc\BlogBundle\LtcBlogBundle(),
            new Ltc\ArticleBundle\LtcArticleBundle(),
            new Ltc\PackageBundle\LtcPackageBundle(),
            new Ltc\ImportBundle\LtcImportBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    public function registerRootDir()
    {
        return __DIR__;
    }
}
