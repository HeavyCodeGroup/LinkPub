<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Installer;

use Doctrine\ORM\EntityManager;
use HeavyCodeGroup\LinkPub\ConsumerBundle\Exception\BadBundleStructureException;
use HeavyCodeGroup\LinkPub\StorageBundle\Doctrine\DBAL\ConsumerStatusType;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Consumer;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerImplementation;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractBaseInstaller implements InstallerInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var string
     */
    private $installDirectory;

    /**
     * @var string
     */
    private $implementationName;

    /**
     * @var ConsumerImplementation
     */
    private $implementationEntity;

    /**
     * @var string
     */
    private $consumerGUID;

    /**
     * @var \DateTime
     */
    private $releaseDate;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var array
     */
    private $consumerConfig;

    /**
     * @param Filesystem $filesystem
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $installDirectory
     */
    public function setInstallDirectory($installDirectory)
    {
        $this->installDirectory = $installDirectory;
    }

    /**
     * @param string $implementation
     */
    public function setImplementationName($implementation)
    {
        $this->implementationName = $implementation;
    }

    public function init($consumerSourcesPath)
    {
        $this->basePath = $consumerSourcesPath;
        $configFilename = $this->basePath . '/consumer.yml';
        if (!is_file($configFilename) || !is_readable($configFilename)) {
            throw new BadBundleStructureException('Required config file consumer.yml is missing or unreadable');
        }

        $config = Yaml::parse(file_get_contents($configFilename));
        $this->consumerConfig = $config;
        $this->checkRequiredParameters(array(
            'implementation',
            'consumer_guid',
            'release_date',
        ));

        if ($config['implementation'] != $this->getImplementationName()) {
            throw new \InvalidArgumentException('Bad implementation name in consumer.yml');
        }

        /**
         * @var \HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\ConsumerImplementationRepository $implementationRepository
         * @var ConsumerImplementation $implementation
         */
        $implementationRepository = $this->entityManager->getRepository('LinkPubStorageBundle:ConsumerImplementation');
        if (!$implementation = $implementationRepository->find($this->getImplementationName())) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Requested consumer implementation %s does not exists in database',
                    $this->getImplementationName()
                )
            );
        }
        $this->implementationEntity = $implementation;

        if (!preg_match('/^[a-f0-9]{8}\-[a-f0-9]{4}\-[a-f0-9]{4}\-[a-f0-9]{4}\-[a-f0-9]{12}$/i', $config['consumer_guid'])) {
            throw new \InvalidArgumentException('Consumer GUID in bundle has invalid format');
        }

        $this->consumerGUID = $config['consumer_guid'];
        if ($this->getFilesystem()->exists($this->getInstallPath())) {
            throw new \InvalidArgumentException(
                sprintf('Consumer with GUID %s already exists in filesystem', $this->getConsumerGUID())
            );
        }

        /**
         * @var \HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\ConsumerRepository $consumerRepository
         */
        $consumerRepository = $this->entityManager->getRepository('LinkPubStorageBundle:Consumer');
        if ($consumerRepository->findOneBy(array('guid' => $this->getConsumerGUID()))) {
            throw new \InvalidArgumentException(
                sprintf('Consumer with GUID %s already exists in database', $this->getConsumerGUID())
            );
        }


        $releaseDate = new \DateTime($config['release_date']);
        if (!($releaseDate instanceof \DateTime)) {
            throw new \InvalidArgumentException('Failed to parse release date from bundle.');
        }
        $this->releaseDate = $releaseDate;
    }

    public function install()
    {
        $consumer = new Consumer();
        $consumer->setImplementation($this->getImplementationEntity());
        $consumer->setGuid($this->getConsumerGUID());
        $consumer->setDateReleased($this->getReleaseDate());
        $consumer->setStatus(ConsumerStatusType::STATUS_ACTIVE);

        $this->getEntityManager()->persist($consumer);

        $this->getEntityManager()->flush();
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return string
     */
    protected function getInstallDirectory()
    {
        return $this->installDirectory;
    }

    protected function getInstallPath()
    {
        return $this->getInstallDirectory() . '/' . $this->getConsumerGUID();
    }

    /**
     * @return string
     */
    protected function getImplementationName()
    {
        return $this->implementationName;
    }

    /**
     * @return ConsumerImplementation
     */
    protected function getImplementationEntity()
    {
        return $this->implementationEntity;
    }

    /**
     * @return string
     */
    protected function getConsumerGUID()
    {
        return $this->consumerGUID;
    }

    /**
     * @return \DateTime
     */
    protected function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @return string
     */
    protected function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return array
     */
    protected function getConsumerConfig()
    {
        return $this->consumerConfig;
    }

    /**
     * @param array $parameters
     * @throws BadBundleStructureException
     */
    protected function checkRequiredParameters(array $parameters)
    {
        foreach ($parameters as $parameter) {
            if (!isset($this->consumerConfig[$parameter])) {
                throw new BadBundleStructureException(
                    sprintf('Required config parameter \'%s\' is missing', $parameter)
                );
            }
        }
    }
}
