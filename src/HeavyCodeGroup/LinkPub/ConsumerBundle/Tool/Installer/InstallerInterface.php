<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Installer;

interface InstallerInterface
{
    public function init($consumerSourcesPath);

    public function install();
}
