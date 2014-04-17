<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Installer;

use HeavyCodeGroup\LinkPub\ConsumerBundle\Exception\BadBundleStructureException;
use Symfony\Component\Yaml\Yaml;

class PhpInstaller extends AbstractBaseInstaller
{
    /**
     * @var array
     */
    private $fileBase = array();

    /**
     * @var string
     */
    private $classBase = null;

    /**
     * @var array
     */
    private $methodOverride = array();

    public function init($consumerSourcesPath)
    {
        parent::init($consumerSourcesPath);

        $this->checkRequiredParameters(array(
            'file_base',
            'class_base',
            'method_overrides',
        ));
        $config = $this->getConsumerConfig();
        if (!is_array($config['file_base'])) {
            throw new BadBundleStructureException(
                sprintf('Required attribute \'%s\' must be an array', 'file_base')
            );
        }
        if (!is_array($config['method_overrides'])) {
            throw new BadBundleStructureException(
                sprintf('Required attribute \'%s\' must be an array', 'file_base')
            );
        }

        $files = array_map(function ($filename) use ($consumerSourcesPath) {
            return $consumerSourcesPath . '/' . $filename;
        }, $config['file_base']);
        if (!$this->getFilesystem()->exists($files)) {
            throw new BadBundleStructureException('Some base files are missing');
        }

        $this->fileBase = $files;
        $this->classBase = $config['class_base'];
        $this->methodOverride = $config['method_overrides'];
    }

    public function install()
    {
        $this->getFilesystem()->mkdir($this->getInstallPath());

        // Stripping stating <?php from each base file
        $base = array();
        foreach ($this->fileBase as $filename) {
            foreach (array_slice(file($filename), 1) as $line) {
                array_push($base, rtrim($line));
            }
        }
        array_unshift($base, '<?php');
        array_push($base, '', '');
        file_put_contents($this->getInstallPath() . '/consumer.php', implode("\n", $base));

        file_put_contents($this->getInstallPath() . '/consumer.yml', Yaml::dump(array(
            'class_base' => $this->classBase,
            'method_override' => $this->methodOverride,
        )));

        parent::install();
    }
}
