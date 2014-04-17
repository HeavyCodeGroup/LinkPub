<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;

class PageRepository extends EntityRepository
{
    /**
     * @param Site $site
     * @return \Doctrine\ORM\Query
     */
    public function getPagesBySiteQuery(Site $site)
    {
        return $this->createQueryBuilder('page')
            ->where('page.site = :site')
            ->setParameter(':site', $site)
            ->getQuery()
        ;
    }
}
