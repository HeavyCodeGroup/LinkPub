<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle;

use HeavyCodeGroup\LinkPub\StorageBundle\DependencyInjection\Compiler\AddEnumDoctrineTypePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;
use HeavyCodeGroup\LinkPub\StorageBundle\DBAL\PageStatusType;
use HeavyCodeGroup\LinkPub\StorageBundle\DBAL\LinkStatusType;
use HeavyCodeGroup\LinkPub\StorageBundle\DBAL\LinkProblemType;

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

        if (!Type::hasType(LinkStatusType::ENUM_LINK_STATUS)) {
            Type::addType(
                LinkStatusType::ENUM_LINK_STATUS,
                'HeavyCodeGroup\LinkPub\StorageBundle\DBAL\LinkStatusType'
            );
        }

        if (!Type::hasType(LinkProblemType::ENUM_LINK_PROBLEM)) {
            Type::addType(
                LinkProblemType::ENUM_LINK_PROBLEM,
                'HeavyCodeGroup\LinkPub\StorageBundle\DBAL\LinkProblemType'
            );
        }
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddEnumDoctrineTypePass());
    }
}
