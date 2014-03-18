<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;
use HeavyCodeGroup\LinkPub\UserBundle\Entity\User;

class SiteRepository extends EntityRepository
{

    public function findAllByUserQuery(User $user)
    {
        return $this
            ->createQueryBuilder('site')
            ->where('site.owner = :owner')
            ->setParameter(':owner', $user)
        ;
    }
}
