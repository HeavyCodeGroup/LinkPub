<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class LinkPubDispenserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('link_pub_dispenser.dispense_interval', $config['dispense_interval']);
        if ($config['router_listener']) {
            $loader->load('router_listener.xml');
        }
        if ($config['exception_listener']) {
            $loader->load('exception_listener.xml');
        }
    }
}
