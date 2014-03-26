<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Packager;

interface PackagerInterface
{
    public function getOutputFilename($name);

    public function pack($directory, $filename);
}
