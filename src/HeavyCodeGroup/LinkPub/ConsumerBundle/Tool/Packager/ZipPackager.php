<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

use Symfony\Component\Filesystem\Exception\IOException;

class ZipPackager extends AbstractBasePackager
{
    public function pack($directory, $filename)
    {
        $filename = $this->getOutputDirectory() . '/' . $filename . '.zip';
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
