<?php

namespace HeavyCodeGroup\FrameworkMiniBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class FrameworkMiniExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('web.xml');
        $loader->load('services.xml');

        if ($container->getParameter('kernel.debug')) {
            $loader->load('debug.xml');
        }
    }
}
