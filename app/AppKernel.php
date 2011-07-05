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
            new Symfony\Bundle\DoctrineMongoDBBundle\DoctrineMongoDBBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),

            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Bundle\ApcBundle\ApcBundle(),
            new FOQ\ElasticaBundle\FOQElasticaBundle(),
            new FOQ\TyperBundle\FOQTyperBundle(),
            new FOS\CommentBundle\FOSCommentBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Knplabs\Bundle\GaufretteBundle\KnplabsGaufretteBundle(),
            new Knplabs\Bundle\MenuBundle\KnplabsMenuBundle(),
            new Ornicar\AkismetBundle\OrnicarAkismetBundle(),
            new Ornicar\InsaneMarkdownBundle\OrnicarInsaneMarkdownBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),

            new Ltc\UserBundle\LtcUserBundle(),
            new Ltc\CommentBundle\LtcCommentBundle(),
            new Ltc\CoreBundle\LtcCoreBundle(),
            new Ltc\DocBundle\LtcDocBundle(),
            new Ltc\BlogBundle\LtcBlogBundle(),
            new Ltc\ArticleBundle\LtcArticleBundle(),
            new Ltc\FileBundle\LtcFileBundle(),
            new Ltc\ImageBundle\LtcImageBundle(),
            new Ltc\TagBundle\LtcTagBundle(),
            new Ltc\StoryBundle\LtcStoryBundle(),
            new Ltc\CompatBundle\LtcCompatBundle(),
            new Ltc\ConfigBundle\LtcConfigBundle(),
            new Ltc\ImportBundle\LtcImportBundle(),
            new Ltc\AdminBundle\LtcAdminBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Symfony\Bundle\DoctrineFixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
