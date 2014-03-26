<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernelDispenser extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new HeavyCodeGroup\FrameworkMiniBundle\FrameworkMiniBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new HeavyCodeGroup\LinkPub\DispenserBundle\LinkPubDispenserBundle(),
        );

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
