<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Page;

class PageListener implements EventSubscriber
{
    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Page) {
            $entity->setLevel($this->getMinimalPageLevel($entity));
        }
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof Page) {
            $entity->setLevel($this->getMinimalPageLevel($entity));
            // Force update
            $em = $event->getEntityManager();
            $uow = $em->getUnitOfWork();
            $meta = $em->getClassMetadata('LinkPubStorageBundle:Page');
            $uow->recomputeSingleEntityChangeSet($meta, $entity);
        }
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
        );
    }

    protected function getMinimalPageLevel(Page $page, $chain = array())
    {
        $rootPage = $page->getSite()->getRootPage();
        if ($rootPage instanceof Page) {
            if ($page === $rootPage) {
                return count($chain);
            }

            $listener = $this;
            $levels = array_filter(array_map(function (Page $parent) use ($listener, $chain, $page) {
                if (in_array($parent, $chain, true)) {
                    return null; // Avoid recursion
                }

                return $listener->getMinimalPageLevel($parent, array_merge($chain, array($page)));
            }, $page->getParents()->toArray()), function ($level) {
                return ($level !== null);
            });

            return count($levels) ? min($levels) : null;
        }

        return null;
    }
}
