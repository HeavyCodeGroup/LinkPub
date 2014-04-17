<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle;

use HeavyCodeGroup\LinkPub\ConsumerBundle\DependencyInjection\Compiler\RegisterBuildersPass;
use HeavyCodeGroup\LinkPub\ConsumerBundle\DependencyInjection\Compiler\RegisterInstallersPass;
use HeavyCodeGroup\LinkPub\ConsumerBundle\DependencyInjection\Compiler\RegisterPackagersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LinkPubConsumerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterInstallersPass());
        $container->addCompilerPass(new RegisterBuildersPass());
        $container->addCompilerPass(new RegisterPackagersPass());
    }
}
