<?php

namespace Ltc\ConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\FileLocator;

class LtcConfigExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->process($configuration->getConfigTree(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.xml');

        $referenceMap = array();
        foreach ($config as $name => $options) {
            $repoId  = 'ltc_config.repository.'.$name;
            $repoDef = $container->setDefinition($repoId, new DefinitionDecorator('ltc_config.repository'));
            $repoDef->setArgument(0, $options['model']);
            $formFactoryId  = 'ltc_config.form_factory.'.$name;
            $formFactoryDef = $container->setDefinition($formFactoryId, new DefinitionDecorator('ltc_config.form_factory'));
            $formFactoryDef->setArgument(1, $name);
            $formFactoryDef->setArgument(2, $options['form']);
            $configId = 'ltc_config.'.$name;
            $configDef = $container->setDefinition($configId, new DefinitionDecorator('ltc_config.config'));
            $configDef->setArgument(0, new Reference($repoId));
            $configDef->setArgument(1, new Reference($formFactoryId));
            $configDef->setArgument(2, $name);
            $configDef->setArgument(3, $options['title']);
            $referenceMap[$name] = new Reference($configId);
        }

        $container->getDefinition('ltc_config.manager')->setArgument(0, $referenceMap);
    }
}
