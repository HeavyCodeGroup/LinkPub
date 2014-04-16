<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterInstallersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $taggedInstallers = $container->findTaggedServiceIds('link_pub_consumer.installer');
        $mainInstaller = $container->getDefinition('link_pub_consumer.installer');
        foreach ($taggedInstallers as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $mainInstaller
                    ->addMethodCall('addInstaller', array($attributes['implementation'], $serviceId));
                $container->getDefinition($serviceId)
                    ->addMethodCall(
                        'setImplementationName',
                        array($attributes['implementation'])
                    );
            }
        }
    }
}
