<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;

class LinkRepository extends EntityRepository
{
    /**
     * @param Site $site
     * @return \Doctrine\ORM\Query
     */
    public function getInComingBySiteQuery(Site $site)
    {
        return $this->createQueryBuilder('link')
            ->innerJoin('link.trackingPage', 'page')
            ->where('page.site = :site')
            ->setParameter(':site', $site)
            ->getQuery()
        ;
    }

    /**
     * @param Site $site
     * @return \Doctrine\ORM\Query
     */
    public function getOutGoingBySiteQuery(Site $site)
    {
        return $this->createQueryBuilder('link')
            ->innerJoin('link.page', 'page')
            ->where('page.site = :site')
            ->setParameter(':site', $site)
            ->getQuery()
            ;
    }
}
