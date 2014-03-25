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
    protected $builders = array();

    /**
     * @var array
     */
    protected $packagers = array();

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
            $dir = $this->getBuilder($consumer->getImplementation()->getId())->build($instance);
            foreach ($this->packagers as $packagerFormat => $packagerService) {
                $this->getPackager($packagerFormat)->pack($dir, $instance->getGuid());
            }
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
     * @param string $format
     * @param string $serviceId
     */
    public function addPackager($format, $serviceId)
    {
        $this->packagers[$format] = $serviceId;
    }

    public function getAvailableFormats()
    {
        return array_keys($this->packagers);
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param string $implementation
     * @return \HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Builder\BuilderInterface
     */
    protected function getBuilder($implementation)
    {
        return $this->getContainer()->get($this->builders[$implementation]);
    }

    /**
     * @param string $format
     * @return \HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager\PackagerInterface
     */
    protected function getPackager($format)
    {
        return $this->getContainer()->get($this->packagers[$format]);
    }
}
