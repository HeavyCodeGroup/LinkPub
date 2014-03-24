<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool;

use Doctrine\ORM\EntityManager;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Consumer;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerInstance;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;

class BuilderTool extends AbstractBaseTool
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    protected $builders;

    /**
     * @param Site $site
     * @param Consumer $consumer
     * @return ConsumerInstance
     */
    public function getInstance(Site $site, Consumer $consumer)
    {
        /**
         * @var \HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\ConsumerInstanceRepository $instanceRepository
         */
        $instanceRepository = $this->getEntityManager()->getRepository('LinkPubStorageBundle:ConsumerInstance');
        $instance = $instanceRepository->findOneBy(array(
            'site' => $site,
            'consumer' => $consumer,
        ));
        if (!($instance instanceof ConsumerInstance)) {
            $instance = new ConsumerInstance();
            $instance->setSite($site);
            $instance->setConsumer($consumer);

            $this->getEntityManager()->persist($instance);
            // TODO: Build personal consumer
            $this->getEntityManager()->flush();
        }

        return $instance;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $implementation
     * @param string $serviceId
     */
    public function addBuilder($implementation, $serviceId)
    {
        $this->builders[$implementation] = $serviceId;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    protected function getBuilder($implementation)
    {
        return $this->getContainer()->get($this->builders[$implementation]);
    }
}
