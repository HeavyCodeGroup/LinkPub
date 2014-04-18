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
        return $this
            ->createQueryBuilder('page')
            ->where('page.site = :site')
            ->setParameter(':site', $site)
            ->getQuery()
        ;
    }

    public function getPagesByCriteriaQuery($criteria)
    {
        return $this
            ->createQueryBuilder('page')
            ->innerJoin('page.site', 'site')
            ->where('site.tci BETWEEN :tciMin AND :tciMax')
            ->andWhere('page.pageRank = :pageRank')
            ->andWhere('site.category = :category')
            ->andWhere('page.price = :price')
            ->andWhere('page.level = :level')
            ->andWhere('site.owner != :user')
            ->andWhere('page.state = :state')
            ->orderBy('page.site')
            ->setParameters($criteria)
            ->getQuery()
        ;
    }
}
