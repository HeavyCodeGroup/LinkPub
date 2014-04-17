<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

class TarPackager extends AbstractBasePackager
{
    public function getOutputFilename($name)
    {
        return $this->getOutputDirectory() . '/' . $name . '.tar';
    }

    public function pack($directory, $filename)
    {
        $tar = new \PharData($filename);
        $tar->buildFromDirectory($directory);

        return $filename;
    }
}
