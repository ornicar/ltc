<?php

namespace Ltc\ConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\DependencyInjection\Configuration\NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ltc_config', 'array');

        $rootNode
            ->useAttributeAsKey('key')
            ->prototype('array')
                ->performNoDeepMerging()
                ->children()
                    ->scalarNode('model')->end()
                    ->scalarNode('form')->end()
                    ->scalarNode('title')->end()
                    ->scalarNode('form_factory')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder->buildTree();
    }
}
