<?php

namespace HeavyCodeGroup\LinkPub\StorageBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class AddEnumDoctrineTypePass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @throws InvalidArgumentException
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $connections = $container->getParameter('doctrine.connections');
        foreach ($connections as $connectionDefinitionName) {
            $definition = $container->getDefinition($connectionDefinitionName);
            $arguments = $definition->getArguments();
            if (!is_array($arguments)) {
                throw new InvalidArgumentException(
                    sprintf("Arguments of %s must be an array", $connectionDefinitionName)
                );
            }
            if (!isset($arguments[3])) {
                $arguments[3] = array();
            }
            if (!is_array($arguments[3])) {
                throw new InvalidArgumentException(
                    sprintf("Argument 3 of %s must be an array", $connectionDefinitionName)
                );
            }
            if (!isset($arguments[3]['enum'])) {
                $arguments[3]['enum'] = 'string';
            }
            $definition->setArguments($arguments);
        }
    }
}
