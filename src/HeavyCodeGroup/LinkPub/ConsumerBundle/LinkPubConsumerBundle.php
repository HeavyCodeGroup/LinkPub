<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle;

use HeavyCodeGroup\LinkPub\ConsumerBundle\DependencyInjection\Compiler\RegisterInstallersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LinkPubConsumerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterInstallersPass());
    }
}
