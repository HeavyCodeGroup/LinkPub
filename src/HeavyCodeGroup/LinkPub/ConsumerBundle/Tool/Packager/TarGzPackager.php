<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

class TarGzPackager extends AbstractCompressingPackager
{
    public function getOutputFilename($name)
    {
        return $this->getParentPackager()->getOutputFilename($name) . '.gz';
    }

    public function pack($directory, $filename)
    {
        $tarArchive = preg_replace('/\.gz$/i', '', $filename);
        if (!$this->getFilesystem()->exists($tarArchive)) {
            $this->getParentPackager()->pack($directory, $tarArchive);
        }

        $tar = new \PharData($tarArchive);
        $tar->compress(\Phar::GZ);

        return $filename;
    }
}
