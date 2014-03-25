<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Builder;

use HeavyCodeGroup\LinkPub\ConsumerBundle\Exception\SystemLifetimeException;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerInstance;
use Symfony\Component\Filesystem\Filesystem;

class AbstractBaseBuilder implements BuilderInterface
{
    /**
     * @var string
     */
    protected $sourcesPath;

    /**
     * @var string
     */
    protected $outputPath;

    /**
     * @var string
     */
    protected $instanceGUID;

    /**
     * @var array
     */
    protected $dispenserHosts;

    /**
     * @var string
     */
    private $sourcesDirectory;

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param string $sourcesDirectory
     */
    public function setSourcesDirectory($sourcesDirectory)
    {
        $this->sourcesDirectory = $sourcesDirectory;
    }

    /**
     * @param string $outputDirectory
     */
    public function setOutputDirectory($outputDirectory)
    {
        $this->outputDirectory = $outputDirectory;
    }

    /**
     * @param Filesystem $filesystem
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function setDispenserHosts(array $dispenserHosts)
    {
        $this->dispenserHosts = $dispenserHosts;
    }

    public function build(ConsumerInstance $consumer)
    {
        $this->sourcesPath = $this->sourcesDirectory . '/' . $consumer->getConsumer()->getGuid();

        do {
            $this->outputPath = $this->getOutputDirectory() . '/' . uniqid('consumer_build_');
        } while ($this->getFilesystem()->exists($this->outputPath));
        $this->getFilesystem()->mkdir($this->outputPath, 0700);

        $this->instanceGUID = $consumer->getGuid();

        return $this->outputPath;
    }

    /**
     * @return string
     */
    protected function getSourcesDirectory()
    {
        return $this->sourcesDirectory;
    }

    /**
     * @return string
     */
    protected function getOutputDirectory()
    {
        return $this->outputDirectory;
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->filesystem;
    }

    protected function checkRequiredFiles($files)
    {
        foreach ($files as $file) {
            if(!$this->getFilesystem()->exists($file)) {
                throw new SystemLifetimeException(
                    sprintf('Required file %s was not found, looks like installation was damaged', $file)
                );
            }
        }
    }
}
