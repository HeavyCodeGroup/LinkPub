<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\Builder;

use HeavyCodeGroup\LinkPub\StorageBundle\Entity\ConsumerInstance;
use Symfony\Component\Yaml\Yaml;

class PhpBuilder extends AbstractBaseBuilder
{
    public function build(ConsumerInstance $consumer)
    {
        parent::build($consumer);
        $sourcesPath = $this->sourcesPath;

        $this->checkRequiredFiles(array_map(function ($file) use ($sourcesPath) {
            return $sourcesPath . '/' . $file;
        }, array('consumer.php', 'consumer.yml')));

        $config = Yaml::parse(file_get_contents($sourcesPath . '/consumer.yml'));
        $classBase = $config['class_base'];
        $methodOverride = $config['method_override'];
        $class = $this->getClass('LinkPubConsumer', $classBase, $methodOverride);

        file_put_contents(
            $this->outputPath . '/LinkPubConsumer.php',
            file_get_contents($sourcesPath . '/consumer.php') . implode('', array_map(function ($line) {
                return "$line\n";
            }, $class))
        );

        return $this->outputPath;
    }

    /**
     * @param string $name
     * @param string $parent
     * @param array $methodOverride
     * @return array
     */
    private function getClass($name, $parent, $methodOverride = array())
    {
        $class = array();
        $class[] = "class $name extends $parent";
        $class[] = '{';
        foreach ($methodOverride as $name => $context) {
            $class = array_merge(
                $class,
                array_map(function ($line) {
                    return '    ' . $line;
                }, $this->getMethod($name, $context))
            );
        }
        $class[] = '}';

        return $class;
    }

    /**
     * @param string $name
     * @param string $context
     * @return array
     */
    private function getMethod($name, $context)
    {
        switch ($context) {
            case 'available_dispenser_hosts':
                return $this->getMethodAvailableDispenserHosts($name);
                break;
            case 'instance_guid':
                return $this->getMethodInstanceGUID($name);
                break;
        }

        return array();
    }

    private function getMethodAvailableDispenserHosts($name)
    {
        $method = array();
        $method[] = "protected function $name()";
        $method[] = '{';
        $method[] = "    return array(";
        $method = array_merge($method, array_map(function ($host) {
            return "        '$host',";
        }, $this->dispenserHosts));
        $method[] = "    );";
        $method[] = '}';

        return $method;
    }

    private function getMethodInstanceGUID($name)
    {
        $method = array();
        $method[] = "protected function $name()";
        $method[] = '{';
        $method[] = "    return '{$this->instanceGUID}';";
        $method[] = '}';

        return $method;
    }
}
