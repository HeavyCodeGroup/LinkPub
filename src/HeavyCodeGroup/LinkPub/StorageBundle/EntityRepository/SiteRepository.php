<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;
use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;

class SiteRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllByUserQuery(User $user)
    {
        return $this
            ->createQueryBuilder('site')
            ->select('site as siteFields',
                'category.title as siteCategoryTitle',
                'count(DISTINCT pages.id) as pagesCount',
                'count(linksOn.id) as linksCountOutgoing',
                'count(linksTracked.id) as linksCountIncoming'
            )
            ->leftJoin('site.pages', 'pages')
            ->leftJoin('pages.linksOn', 'linksOn')
            ->leftJoin('pages.linksTracked', 'linksTracked')
            ->leftJoin('site.category', 'category')
            ->where('site.owner = :owner')
            ->groupBy('site')
            ->setParameter(':owner', $user)
        ;
    }

    /**
     * @param $criterion
     * @return \Doctrine\ORM\Query
     */
    public function findOneByIdOrGuidQuery($criterion)
    {
        return $this->createQueryBuilder('site')
            ->where('site.id = :criterion')
            ->orWhere('site.guid = :criterion')
            ->setParameter(':criterion', $criterion)
            ->getQuery()
        ;
    }

    /**
     * @param $criterion
     * @return mixed
     */
    public function findOneByIdOrGuid($criterion)
    {

        return $this
            ->findOneByIdOrGuidQuery($criterion)
            ->getSingleResult()
        ;
    }
}
