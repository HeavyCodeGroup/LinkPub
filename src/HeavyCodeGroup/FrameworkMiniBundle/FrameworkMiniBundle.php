<?php

namespace HeavyCodeGroup\FrameworkMiniBundle;

use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Scope;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Bundle\FrameworkBundle\Command as SymfonyFrameworkCommand;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler as SymfonyFrameworkCompiler;
use Symfony\Component\HttpKernel\DependencyInjection\RegisterListenersPass;

class FrameworkMiniBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        // Register commands from this bundle
        parent::registerCommands($application);

        // Register commands from Symfony\FrameworkBundle
        $application->add(new SymfonyFrameworkCommand\CacheClearCommand());
        $application->add(new SymfonyFrameworkCommand\CacheWarmupCommand());
        $application->add(new SymfonyFrameworkCommand\ContainerDebugCommand());
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addScope(new Scope('request'));

        $container->addCompilerPass(new RegisterListenersPass(), PassConfig::TYPE_BEFORE_REMOVING);
        $container->addCompilerPass(new SymfonyFrameworkCompiler\AddCacheWarmerPass());
        $container->addCompilerPass(new SymfonyFrameworkCompiler\AddCacheClearerPass());

        if ($container->getParameter('kernel.debug')) {
            $container->addCompilerPass(
                new SymfonyFrameworkCompiler\ContainerBuilderDebugDumpPass(),
                PassConfig::TYPE_AFTER_REMOVING
            );
            $container->addCompilerPass(
                new SymfonyFrameworkCompiler\CompilerDebugDumpPass(),
                PassConfig::TYPE_AFTER_REMOVING
            );
        }
    }
}
