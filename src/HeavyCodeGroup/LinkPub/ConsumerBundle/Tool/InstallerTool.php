<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool;

use HeavyCodeGroup\LinkPub\ConsumerBundle\Exception\BadBundleStructureException;
use Symfony\Component\Yaml\Yaml;

class InstallerTool extends AbstractBaseTool
{
    /**
     * @var string
     */
    protected $sourceDirectory;

    /**
     * @var array
     */
    protected $installers;

    /**
     * @param string $implementation
     * @param string $serviceId
     */
    public function addInstaller($implementation, $serviceId)
    {
        $this->installers[$implementation] = $serviceId;
    }

    public function installFromDirectory($directory)
    {
        $this->sourceDirectory = $directory;
        $configFilename = $this->sourceDirectory . '/consumer.yml';
        if (!is_file($configFilename) || !is_readable($configFilename)) {
            throw new BadBundleStructureException('Required config file consumer.yml is missing');
        }

        $config = Yaml::parse(file_get_contents($configFilename));
        /* @var \HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Installer\InstallerInterface $installer */
        $installer = $this->getInstaller($config['implementation']);

        $installer->init($this->sourceDirectory);
        $installer->install();
    }

    protected function getInstaller($implementation)
    {
        return $this->getContainer()->get($this->installers[$implementation]);
    }
}
