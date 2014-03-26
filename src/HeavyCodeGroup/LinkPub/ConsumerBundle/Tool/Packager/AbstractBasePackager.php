<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractBasePackager implements PackagerInterface
{
    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem, $outputDirectory)
    {
        $this->filesystem = $filesystem;
        $this->outputDirectory = $outputDirectory;
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
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param string $directory
     * @return \RecursiveIteratorIterator
     */
    protected function getDirectoryContents($directory)
    {
        return new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, 0),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
    }
}
