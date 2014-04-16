<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

class TarBz2Packager extends AbstractCompressingPackager
{
    public function getOutputFilename($name)
    {
        return $this->getParentPackager()->getOutputFilename($name) . '.bz2';
    }

    public function pack($directory, $filename)
    {
        $tarArchive = preg_replace('/\.bz2$/i', '', $filename);
        if (!$this->getFilesystem()->exists($tarArchive)) {
            $this->getParentPackager()->pack($directory, $tarArchive);
        }

        $tar = new \PharData($tarArchive);
        $tar->compress(\Phar::BZ2);

        return $filename;
    }
}
