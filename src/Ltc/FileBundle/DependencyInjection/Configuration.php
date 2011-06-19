<?php

namespace Ltc\FileBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ltc_file', 'array');

        $rootNode
            ->children()
                ->arrayNode('filesystem_web_path')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
