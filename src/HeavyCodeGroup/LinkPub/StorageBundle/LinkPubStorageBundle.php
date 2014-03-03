<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle;

use HeavyCodeGroup\LinkPub\StorageBundle\DependencyInjection\Compiler\AddEnumDoctrineTypePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;
use HeavyCodeGroup\LinkPub\StorageBundle\DBAL\PageStatusType;

class LinkPubStorageBundle extends Bundle
{
    public function boot()
    {
        parent::boot();
        if (!Type::hasType(PageStatusType::ENUM_PAGE_STATUS)) {
            Type::addType(
                PageStatusType::ENUM_PAGE_STATUS,
                'HeavyCodeGroup\LinkPub\StorageBundle\DBAL\PageStatusType'
            );
        }
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddEnumDoctrineTypePass());
    }
}
