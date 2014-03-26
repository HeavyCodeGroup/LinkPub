<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

use Symfony\Component\Filesystem\Filesystem;

abstract class AbstractCompressingPackager implements PackagerInterface
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var PackagerInterface
     */
    private $parentPackager;

    public function __construct(Filesystem $filesystem, PackagerInterface $parentPackager)
    {
        $this->filesystem = $filesystem;
        $this->parentPackager = $parentPackager;
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @return PackagerInterface
     */
    protected function getParentPackager()
    {
        return $this->parentPackager;
    }
}
