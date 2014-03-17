<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('link_pub_dispenser');

        $rootNode
            ->children()
                ->integerNode('dispense_interval')
                ->defaultValue('1800')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
 