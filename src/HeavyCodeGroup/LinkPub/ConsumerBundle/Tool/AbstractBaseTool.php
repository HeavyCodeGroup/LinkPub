<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractBaseTool
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(ContainerInterface $container, Filesystem $filesystem)
    {
        $this->container = $container;
        $this->filesystem = $filesystem;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->filesystem;
    }
}
