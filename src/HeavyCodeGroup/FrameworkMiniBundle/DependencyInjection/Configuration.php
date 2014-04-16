<?php

namespace HeavyCodeGroup\FrameworkMiniBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('framework_mini');

        $rootNode
            ->children()
                ->scalarNode('secret')->end()
                ->scalarNode('http_method_override')
                    ->info("Set true to enable support for the '_method' request parameter to determine the intended HTTP method on POST requests.")
                    ->defaultTrue()
                ->end()
                ->arrayNode('trusted_proxies')
                    ->beforeNormalization()
                        ->ifTrue(function ($v) { return !is_array($v) && !is_null($v); })
                        ->then(function ($v) { return is_bool($v) ? array() : preg_split('/\s*,\s*/', $v); })
                    ->end()
                    ->prototype('scalar')
                        ->validate()
                            ->ifTrue(function ($v) {
                                if (empty($v)) {
                                    return false;
                                }

                                if (false !== strpos($v, '/')) {
                                    list($v, $mask) = explode('/', $v, 2);

                                    if (strcmp($mask, (int) $mask) || $mask < 1 || $mask > (false !== strpos($v, ':') ? 128 : 32)) {
                                        return true;
                                    }
                                }

                                return !filter_var($v, FILTER_VALIDATE_IP);
                            })
                            ->thenInvalid('Invalid proxy IP "%s"')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('default_locale')->defaultValue('en')->end()
                ->arrayNode('trusted_hosts')
                    ->beforeNormalization()
                        ->ifTrue(function ($v) { return is_string($v); })
                        ->then(function ($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
