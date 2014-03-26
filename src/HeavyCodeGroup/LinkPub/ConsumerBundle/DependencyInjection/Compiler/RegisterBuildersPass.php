<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterBuildersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $taggedBuilders = $container->findTaggedServiceIds('link_pub_consumer.builder');
        $mainBuilder = $container->getDefinition('link_pub_consumer.builder');
        foreach ($taggedBuilders as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $mainBuilder
                    ->addMethodCall('addBuilder', array($attributes['implementation'], $serviceId));
                // TODO: Find out how to do it with xml
                $container->getDefinition($serviceId)
                    ->addMethodCall('setDispenserHosts', array(
                        $container->getParameter('dispenser_hosts'),
                    ));
            }
        }
    }
}
