<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class ConsumerRepository extends EntityRepository
{
    public function findNewestOneByImplementation($implementation)
    {
        return $this->createQueryBuilder('consumer')
            ->where('consumer.implementation = :implementation')
            ->orderBy('consumer.dateReleased', 'DESC')
            ->setMaxResults(1)
            ->setParameter(':implementation', $implementation)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
