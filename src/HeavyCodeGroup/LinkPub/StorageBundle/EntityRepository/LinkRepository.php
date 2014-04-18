<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;
use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;

class LinkRepository extends EntityRepository
{
    /**
     * @param Site $site
     * @return \Doctrine\ORM\Query
     */
    public function getInComingBySiteQuery(Site $site)
    {
        return $this->createQueryBuilder('link')
            ->innerJoin('link.trackPage', 'page')
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

    /**
     * @param User $user
     * @return \Doctrine\ORM\Query
     */
    public function getInComingByUserQuery(User $user)
    {
        return $this->createQueryBuilder('link')
            ->innerJoin('link.trackPage', 'page')
            ->innerJoin('page.site', 'site')
            ->where('site.owner = :user')
            ->setParameter(':user', $user)
            ->getQuery()
        ;
    }

    /**
     * @param User $user
     * @return \Doctrine\ORM\Query
     */
    public function getOutGoingByUserQuery(User $user)
    {
        return $this->createQueryBuilder('link')
            ->innerJoin('link.page', 'page')
            ->innerJoin('page.site', 'site')
            ->where('site.owner = :user')
            ->setParameter(':user', $user)
            ->getQuery()
        ;
    }
}
