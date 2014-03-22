<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Link;

class SiteLinksUpdateListener implements EventSubscriber
{
    protected $siteIds = array();

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof Link) {
            $siteId = $entity->getPage()->getSite()->getId();
            $this->siteIds[$siteId] = true;
        }
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof Link) {
            $siteId = $entity->getPage()->getSite()->getId();
            $this->siteIds[$siteId] = true;
        }
    }

    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof Link) {
            $siteId = $entity->getPage()->getSite()->getId();
            $this->siteIds[$siteId] = true;
        }
    }

    public function postFlush(PostFlushEventArgs $eventArgs)
    {
        $entityManager = $eventArgs->getEntityManager();

        $siteIds = array_keys($this->siteIds);

        if (count($siteIds)) {
            $entityManager
                ->createQuery('UPDATE LinkPubStorageBundle:Site s SET s.dateLastUpdated = :now WHERE s.id IN (:ids)')
                ->setParameter(':now', new \DateTime('now'))
                ->setParameter(':ids', $siteIds)
                ->execute();
        }
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
            Events::postFlush,
        );
    }
}
