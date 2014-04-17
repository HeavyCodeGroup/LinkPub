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
                ->booleanNode('router_listener')
                    ->defaultFalse()
                ->end()
                ->booleanNode('exception_listener')
                    ->defaultFalse()
                ->end()
                ->booleanNode('tools')
                    ->defaultFalse()
                ->end()
                ->integerNode('dispense_interval')
                    ->defaultValue('1800')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
 