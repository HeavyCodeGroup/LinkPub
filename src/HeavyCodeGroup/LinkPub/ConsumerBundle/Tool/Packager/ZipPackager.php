<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

use Symfony\Component\Filesystem\Exception\IOException;

class ZipPackager extends AbstractBasePackager
{
    public function getOutputFilename($name)
    {
        return $this->getOutputDirectory() . '/' . $name . '.zip';
    }

    public function pack($directory, $filename)
    {
        $directory = rtrim($directory, '/');
        $exclusiveLength = strlen($directory) + 1; // Also strip slash

        $zip = new \ZipArchive();
        if($zip->open($filename, \ZipArchive::OVERWRITE) !== true) {
            throw new IOException(sprintf('Cannot open zip file %s', $filename));
        }

        $files = $this->getDirectoryContents($directory);
        foreach ($files as $file) {
            $zip->addFile($file, substr($file, $exclusiveLength));
        }

        $zip->close();

        return $filename;
    }
}
