<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterPackagersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $taggedPackagers = $container->findTaggedServiceIds('link_pub_consumer.packager');
        $mainBuilder = $container->getDefinition('link_pub_consumer.builder');
        foreach ($taggedPackagers as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $mainBuilder
                    ->addMethodCall('addPackager', array($attributes['format'], $serviceId));
            }
        }
    }
}
